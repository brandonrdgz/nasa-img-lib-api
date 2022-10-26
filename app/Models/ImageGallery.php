<?php

namespace App\Models;

class ImageGallery
{
    private String $masterImageId;
    private String $imageUrl;

    public function __construct(
        String $masterImageId,
        String $imageUrl
    )
    {
        $this->masterImageId = $masterImageId;
        $this->imageUrl = $imageUrl;
    }

    public function __serialize(): array
    {
        return [
            'masterImageUrl' => $this->masterImageId,
            'imageUrl' => $this->imageUrl
        ];
    }
}