<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = array('1'=>'chan-he-thu-xuat-khau', '2' => 'bo-lau-nha-360-do-mau-moi-co-truc-giat-xa-bong', '3' => 'phich-giu-nhiet-inox-elmich', '4' => 'ly-su-co-quai-va-nap-day-love-locklock', '5' => 'lo-vi-song-da-nang-co-nuong-asanzo', '6' => 'may-xay-sinh-to-dien-tu-2-coi-asanzo', '7' => 'noi-com-dien-nap-gai-asanzo', '8' => 'thot-mat-gau-go-duc-thanh', '9' => 'Vi-nuong-trang-men', '10' => 'bo-vot-muoi-da-nang-dien-quang', '11' => 'lot-ly-hinh-vo-so-bo-6-cai-go-duc-thanh', '12' => 'dong-ho-treo-tuong-hinh-tron-vien-mong-vati', '13' => 'binh-giu-nhiet-locklock-new-basic-table', '14' => 'bo-6-dia-nho-thuy-tinh-lily-ville-corelle', '15' => 'bo-hop-com-thuy-tinh-locklock', '16' => 'bo-2-noi-va-1-quanh-elmich-inox', '17' => 'combo-2-ruot-goi-gon-bi-cao-cap-drap24', '18' => 'den-ban-bao-ve-thi-luc-dien-quang', '19' => 'goi-tua-co-hinh-con-cho-thang-loi', '20' => 'ke-dung-do-gia-dung-co-banh-xe-tu-dong');
        $data =[];
        foreach($images as $key => $image)
        {
            $data = [
                'name' => $image,
                'slug'=> $image,
                'path' => 'img/'.$image.'.jpg',
                'filename' => $image,
                'product_id' => $key
            ];
            DB::table('images')->insert($data);
        }
    }
}
