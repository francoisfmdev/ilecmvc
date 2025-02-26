<?php
namespace Controllers;
use Models\ListingModel;

class ListingController extends Controller {

public function index() {
    $listingModel = new ListingModel($this->db);
    $listings = $listingModel->findAll();
    $this->render('listing.html.twig', ['listings' => $listings]);
}


}