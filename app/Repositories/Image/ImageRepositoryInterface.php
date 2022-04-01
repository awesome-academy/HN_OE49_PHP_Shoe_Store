<?php
namespace App\Repositories\Image;

use App\Repositories\RepositoryInterface;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

interface ImageRepositoryInterface extends RepositoryInterface
{
    public function getImage($id);
    public function insert($attributes = []);
    public function getImageName($id);
    public function deleteFileImage($file);
}
