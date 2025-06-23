<?php

namespace Modules\WordpressBlog\Services\Categories;

use App\Models\BlogCategory;
use Modules\WordpressBlog\Services\WpBasicAuthService;



class WpCategoryService
{

    public function getAll()
    {
        return self::wpAuthService()->getCategories();
    }
    public function findWpCategoryById($id)
    {
        return self::wpAuthService()->findCategory($id);
    }
    public function store(array $payloads)
    {   
        return self::wpAuthService()->storeCategory($payloads);
    }
    public function update(array $payloads, $id)
    {
        return self::wpAuthService()->updateCategory($payloads, $id);
    }
    public function delete($id)
    {
        return self::wpAuthService()->deleteCategory($id);
    }
    public function syncCategories()
    {
        $categories = $this->getAll();
        foreach($categories as $category) {
            BlogCategory::updateOrCreate([
                'slug'  => $category->slug,
                'wp_id' => $category->id,
            ], [
                'category_name' => $category->name,
                'is_active' => 1
            ]);
        }
    }
    public static function wpAuthService()
    {
        return new WpBasicAuthService();
    }
}
