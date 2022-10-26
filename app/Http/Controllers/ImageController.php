<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\ImageGallery;
use App\Models\ImageGalleryList;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    private String $baseUrl = "https://images-api.nasa.gov";

    public function index() {
        $imagesResponse = Http::get($this->baseUrl . '/search?q=""')->json();
        $items = $imagesResponse['collection']['items'];
        $images = [];

        foreach($items as $item) {
            array_push(
                $images,
                $this->getImage($item),
            );
        }

        return $images;
    }

    public function show($id)
    {
        $imagesResponse = Http::get($this->baseUrl . '/search?nasa_id=' . $id);
        $items = $imagesResponse['collection']['items'];

        return count($items) != 0 ? $this->getImage($items[0]) : [];
    }

    private function getImage($item): array {
        if(is_null($item)) {
            return [];
        }

        return [
            'id' => $item['data'][0]['nasa_id'],
            'title' => $item['data'][0]['title'],
            'location' => $item['data'][0]['location'] ?? 'Unknown',
            'description' => $item['data'][0]['description'],
            'image_url' => $item['links'][0]['href'],
            'image_gallery' => $this->getImageGalleryList($item['data'][0]['nasa_id'])
        ];
    }

    private function getImageGalleryList(String $imageId): array {
        $imageGalleryResponse = Http::get($this->baseUrl . '/asset/' . $imageId)->json();
        $items = $imageGalleryResponse['collection']['items'];
        $imageGalleryList = [];

        foreach($items as $item) {
            if(preg_match("/(\.jpg)|(\.png)/", $item['href']) != 1) {
                continue;
            }

            array_push(
                $imageGalleryList,
                [
                    'master_image_id' => $imageId,
                    'image_url' => $item['href']
                ]
            );
        }

        return $imageGalleryList;
    }

    /* public function index()
    {
        $imagesResponse = Http::get($this->baseUrl . '/search?q=""')->json();
        $items = $imagesResponse['collection']['items'];
        $images = [];

        foreach($items as $item) {
            array_push(
                $images,
                $this->getImage($item)->__serialize(),
            );
        }

        return $images;
    }

    private function getImage($item) {
        if(is_null($item)) {
            return [];
        }

        return new Image(
            $item['data'][0]['nasa_id'],
            $item['data'][0]['title'],
            $item['data'][0]['location'] ?? '',
            $item['data'][0]['description'] ?? '',
            $item['links'][0]['href'],
            $this->getImageGalleryList($item['data'][0]['nasa_id'])
        );
    }

    private function getImageGalleryList(String $imageId): ImageGalleryList {
        $imageGalleryResponse = Http::get($this->baseUrl . '/asset/' . $imageId)->json();
        $items = $imageGalleryResponse['collection']['items'];
        $imageGalleryList = new ImageGalleryList();

        foreach($items as $item) {
            $imageGalleryList[] = (new ImageGallery(
                $imageId,
                $item['href']
            ))->__serialize();
        }

        return $imageGalleryList;
    }

    public function show($id)
    {
        $imagesResponse = Http::get($this->baseUrl . '/search?nasa_id=' . $id);
        $items = $imagesResponse['collection']['items'];

        return $this->getImage($items[0]);
    } */
}