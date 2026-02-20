<?php
class SystemController extends BaseController {
    public function getFormSystem (){
        $data['content'] = View::make('system.frmSystem');
        return View::make('main', $data);
    }
}