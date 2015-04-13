<?php

class DashboardController extends Controller {

  public function home() {
    return View::make('dashboard.home');
  }

  public function manage() {
    return View::make('dashboard.manage');
  }

  public function services() {
    return View::make('dashboard.services');
  }

  public function settings() {
    return View::make('dashboard.settings');
  }

  public function support() {
    return View::make('dashboard.support');
  }

}
