<?php

namespace App\Models;

class Image 
{
    private String $id;
    private String $title;
    private String $location;
    private String $description;
    private String $imageUrl;
    private ImageGalleryList $imageGalleryList;

    public function __construct(
        String $id,
        String $title,
        String $location,
        String $description,
        String $imageUrl,
        ImageGalleryList $imageGalleryList
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->location = $location;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
        $this->imageGalleryList = $imageGalleryList;
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'location' => $this->location,
            'description' => $this->description,
            'imageUrl' => $this->imageUrl,
            'imageGallery' => $this->imageGalleryList->__serialize()
        ];
    }
}
