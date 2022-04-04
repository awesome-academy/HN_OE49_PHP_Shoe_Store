<?php
namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Image::class;
    }

    public function getImage($id)
    {
        return $this->model::where('product_id', $id)->get();
    }

    public function insert($attributes = [])
    {
        return $this->model::insert($attributes);
    }

    public function getImageName($id)
    {
        return $this->find($id)->name;
    }

    public function deleteFileImage($file)
    {
        if (File::exists($file)) {
            File::delete($file);
            return true;
        } else {
            return false;
        }
    }
}
