<?php

use Model\Calendar;

class Controller_Calendars extends Controller_Template {

    private $calendar;

    /**
     * ルーティング
     * 
     * メソッド名がカレンダーIDの場合は2番目のパラメータをメソッドとする
     * 
     * @param string $method
     * @param string $params
     * @return type
     * @throws HttpNotFoundException
     */
    public function router($method, $params = array()) {
        if (method_exists($this, "action_$method")) {
            return call_user_func_array(array($this, "action_$method"), $params);
        }

        $calendar_id = $method;

        if ($this->calendar = Calendar::get($calendar_id)) {
            if (empty($params)) {
                $params[] = 'index';
            }

            $method = "action_detail_" . array_shift($params);
        }

        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }

        throw new HttpNotFoundException;
    }

    public function action_index() {
        $data = array();

        $data['calendars'] = Calendar::get_all();

        $this->template->title = 'Calendars';
        $this->template->content = View::forge('calendars/index', $data);
    }

    public function action_create() {
        $summary = Input::post('summary');
        $description = Input::post('description');

        Calendar::add($summary, $description);
        
        Response::redirect('calendars');
    }

    public function action_remove($calendar_id) {
        Calendar::remove($calendar_id);
        Response::redirect('calendars');
    }

    public function action_detail_index() {
        $data = array();
        $view = View::forge('calendars/detail');
        
        $view->set_safe('calendar', $this->calendar);
        
        $this->template->title = 'Calendar Detail';
        $this->template->content = $view;
    }

    public function action_detail_add_share() {
        $google_account_id = Input::post('google_account_id');
        
        Calendar::add_share($this->calendar->id, $google_account_id);
        
        Response::redirect("calendars/{$this->calendar->id}/");
    }

    public function action_detail_remove_share($google_account_id) {        
        Calendar::remove_share($this->calendar->id, $google_account_id);                
        Response::redirect("calendars/{$this->calendar->id}/");
    }

}
