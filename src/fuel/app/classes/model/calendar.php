<?php

namespace Model;

/**
 * カレンダーモデル
 */
class Calendar {

    /**
     * Googleカレンダーサービスの取得
     * 
     * @return \Google_Service_Calendar
     */
    public static function get_service() {
        \Config::load('google');

        $client_id = \Config::get('google.service_account.client_id');
        $mail_addr = \Config::get('google.service_account.mail_addr');
        $key = \Config::get('google.service_account.key_file');

        $client = new \Google_Client();
        $client->setApplicationName("Calenader API Sample");

        $cred = new \Google_Auth_AssertionCredentials(
                $mail_addr, array(\Google_Service_Calendar::CALENDAR,
            \Google_Service_Calendar::CALENDAR_READONLY), $key
        );
        $client->setAssertionCredentials($cred);
        $client->setClientId($client_id);

        $service = new \Google_Service_Calendar($client);

        return $service;
    }

    /**
     * カレンダーの取得
     * 
     * @param string $calendar_id カレンダーID
     * @return \stdClass
     */
    public static function get($calendar_id) {
        $service = self::get_service();

        $calendar = $service->calendars->get($calendar_id);
        $acl = $service->acl->listAcl($calendar_id);

        $users = array();
        foreach ($acl as $user) {
            $scope_value = $user->getScope()->getValue();

            $ignore_users = array(
                \Config::get('google.service_account.mail_addr'),
                $calendar_id
            );

            if (in_array($scope_value, $ignore_users)) {
                continue;
            }

            $users[] = $scope_value;
        }

        $obj = new \stdClass();
        $obj->id = $calendar->getId();
        $obj->summary = $calendar->getSummary();
        $obj->description = $calendar->getDescription();
        $obj->users = $users;

        return $obj;
    }

    /**
     * カレンダー一覧の取得
     * 
     * @return array
     */
    public static function get_all() {
        $service = self::get_service();

        $calendarList = $service->calendarList->listCalendarList();

        $calendars = array();
        while (true) {
            foreach ($calendarList->getItems() as $calendarListEntry) {
                $obj = new \stdClass();

                $obj->id = $calendarListEntry->getId();
                $obj->summary = $calendarListEntry->getSummary();
                $obj->description = $calendarListEntry->getDescription();

                $calendars[] = $obj;
            }
            $pageToken = $calendarList->getNextPageToken();
            if ($pageToken) {
                $optParams = array('pageToken' => $pageToken);
                $calendarList = $service->calendarList->listCalendarList($optParams);
            } else {
                break;
            }
        }

        return $calendars;
    }

    /**
     * カレンダーの追加
     * 
     * @param string $summary
     * @param string $description
     */
    public static function add($summary, $description) {
        $service = self::get_service();

        $calendar = new \Google_Service_Calendar_Calendar();
        $calendar->setSummary($summary);
        $calendar->setDescription($description);
        $calendar->setTimeZone('Asia/Tokyo');

        $service->calendars->insert($calendar);
    }

    /**
     * カレンダーの削除
     * 
     * @param string $calendar_id
     */
    public static function remove($calendar_id) {
        $service = self::get_service();
        $service->calendars->delete($calendar_id);
    }

    /**
     * カレンダーの共有ユーザーの追加
     * 
     * カレンダーへの予定の変更権限をもつユーザーを追加する
     * 
     * @param string $calendar_id
     * @param string $google_account_id
     */
    public static function add_share($calendar_id, $google_account_id) {
        $service = self::get_service();

        $scope = new \Google_Service_Calendar_AclRuleScope();
        $scope->setType("user");
        $scope->setValue($google_account_id);

        $rule = new \Google_Service_Calendar_AclRule();
        $rule->setScope($scope);
        $rule->setRole("writer");

        $service->acl->insert($calendar_id, $rule);
    }

    /**
     * カレンダーの共有ユーザーの削除
     * 
     * @param string $calendar_id
     * @param string $google_account_id
     */
    public static function remove_share($calendar_id, $google_account_id) {
        $service = self::get_service();
        $rule_id = 'user:' . $google_account_id;

        $service->acl->delete($calendar_id, $rule_id);
    }

}
