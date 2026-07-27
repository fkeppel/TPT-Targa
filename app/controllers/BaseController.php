<?php
use Illuminate\Routing\Controller;
class BaseController extends Controller {
    public $sals;
    public function __construct() {
        $this->sals = $this->getSALs();
        View::share('SALs', $this->sals);
    }
    public function getSALs() {
        $sals = DB::table('PPBoard')->where('PPBoard_IsActive', "=", 1)->orderBy('PPBoard_Bezeichnung', 'asc')->get();
        if ($sals) {
            return $sals;
        }
        return false;
    }
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
}