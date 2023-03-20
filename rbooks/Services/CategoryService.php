<?php

namespace RBooks\Services;

use RBooks\Models\Category;
use RBooks\Repositories\CategoryRepository;
use DB;
use App\Quotation;

class CategoryService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(CategoryRepository::class);
    }

    public function create($request)
    {
        $data = [
            'name' => $request->name,
            'nameEnglish' => $request->nameEnglish,
            'slug' => $request->slug,
            'description' => $request->description,
            'status' => $request->status,
        ];

        $node = null;
        \DB::transaction(function () use ($request, $data, &$node) {
            $node = $this->repository->create($data);

            if ($request->parent_id) {
                $parent = $this->repository->find($request->parent_id);
                $parent->appendNode($node);
            }
        });

        return $node;
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
            'nameEnglish' => $request->nameEnglish,
            'slug' => $request->slug,
            'description' => $request->description,
            'status' => $request->status,
        ];

        $node = null;
        \DB::transaction(function () use ($request, $data, $id, &$node) {
            $node = $this->repository->update($data, $id);

            if ($request->parent_id) {
                $parent = $this->repository->find($request->parent_id);
                $parent->appendNode($node);
            } else if ($node->parent_id) {
                $node->parent_id = null;
                $node->save();

                Category::fixTree();
            }
        });

        return $node;
    }

    public function delete($id)
    {
        \DB::transaction(function () use ($id) {
            $this->repository->delete($id);
            Category::fixTree();
        });

        return true;
    }

    /**
     * Get main menu categories
     *
     * @return void
     */
    public function getMainMenuCategories()
    {
        return $this->repository->scopeQuery(function($query){
            return $query
                ->orderBy('menu_order','asc')
                ->where('show_menu', true);
        })->all();
    }

    /**
     * Get collection of categories for home page
     * With eager loading
     *
     * @return void
     */
    public function getHomeCategories()
    {
        $this->setWith(['products', 'products.images' => function($query) {
            $query->orderBy('product_id', 'asc')->orderBy('order', 'asc');
        }]);
        $categories = $this->repository->with($this->with)->findWhereIn('id', [1, 44, 22, 47, 43, 45]);
        return $categories->mapWithKeys(function($item) {
            return [$item['id'] => $item];
        });
    }

    public function getListCategories($ids)
    {
        $categories = $this->repository->findWhereIn('id', $ids);
        return $categories;
    }

    public function getAllWithDepth()
    {
        return $this->repository->scopeQuery(function($query) {
            return $query->withDepth()->defaultOrder();
        })->all();
    }

    public function getDataImport($file, $args=array()) {
        $fields = array(
            'header_row'=>true,
            'remove_header_row'=>true,
            'trim_headers'=>true, //cắt khoảng trắng khoảng các giá trị tiêu đề hàng
            'trim_values'=>true, //trỏ khoảng trắng xung quanh tất cả các giá trị hàng không phải là tiêu đề
            'debug'=>false,
            'lb'=>"\n", //xuống dòng
            'tab'=>"\t", //tab
        );

        foreach ($fields as $key => $default) {
            if (array_key_exists($key,$args)) {
                $$key = $args[$key];
            }
            else {
                $$key = $default;
            }
        }

        $data = array();

        if (($handle = fopen($file,'r')) !== false) {
            $contents = fread($handle, filesize($file));
            fclose($handle);
        }
        else {
            custom_die('Đã xảy ra lỗi khi mở tệp.');
        }

        $lines = explode($lb,$contents);

        $row = 0;
        foreach ($lines as $line) {
            $row++;
            if (($header_row) && ($row == 1)) { $data['headers'] = array(); }
            else { $data[$row] = array(); }
            $values = explode($tab,$line);
            foreach ($values as $c => $value) {
                if (($header_row) && ($row == 1)) { //nếu đây là một phần của dòng tiêu đề
                    if (in_array($value,$data['headers'])) {
                        custom_die('Có giá trị nhân bản trong hàng tiêu đề: '.htmlspecialchars($value).'.');
                    }
                    else {
                        if ($trim_headers) {
                            $value = trim($value);
                        }
                        $data['headers'][$c] = $value.''; //'' đảm bảo nó là một chuỗi
                    }
                }
                elseif ($header_row) { //nếu đây không phải là một phần của hàng tiêu đề, nhưng có một hàng tiêu đề
                    $key = $data['headers'][$c];
                    if ($trim_values) { $value = trim($value); }
                    $data[$row][$key] = $value;
                }
                else { //nếu không có hàng tiêu đề ở tất cả
                    $data[$row][$c] = $value;
                }
            }
        }

        if ($remove_header_row) {
            unset($data['headers']);
        }

        return $data;
    }

    public function insertMultiple($tableName, $Data)
    {
        DB::table($tableName)->insert($Data);
    }
}
