<?php
class ServiceController extends Controller {
    public function index() {
        $this->view('services/index', [
            'title' => 'Dịch vụ tại GYMPRO',
            'no_layout' => true
        ]);
    }
}
