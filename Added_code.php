# プラグイン　PDF Image Generator　追加部分
	public function pigen_attachment( $attachment_id ){ // Generate thumbnail from PDF

………

				$return = $thumbnail_id;
				
				#PDF自動投稿用関数呼び出し
				$this->pdf_auto_post($attachment_id);
			} 
		}
		if ( empty( $return ) ) $return = false;
		return $return;
	}

#PDF自動投稿用関数
	public function pdf_auto_post($attachment_id){
		$attachment = get_post( $attachment_id );
		$attach_image_id = get_post_meta( $attachment_id, '_thumbnail_id', true );
		$new_post_title = esc_attr( get_the_title( $attachment_id ) );
		
		if (preg_match('/gaityuu/', $new_post_title)){
			preg_match('/\d{1,4}/', $new_post_title, $num_match); 
			$new_post_title = "外注化阻止ニュース".$num_match[0]."号";
			$cat_id = 3;
		}else if (preg_match('/闘いなくして安全なし/', $new_post_title)){
			preg_match('/\d{1,4}/', $new_post_title, $num_match);
			$new_post_title = "闘いなくして安全なし".$num_match[0]."号";
			$cat_id = 4;
		}else if (preg_match('/支援する会/', $new_post_title)){
			$new_post_title = "動労千葉を支援する会ニュース";
			$cat_id = 5;
		}else{
			return;
		}
		
		$post_data = array(
			'post_title' => $new_post_title, // タイトル
			'post_status' => 'publish', // 公開状態
			'post_category' => array($cat_id), // カテゴリーID配列
			'post_content' => '<a href="'.wp_get_attachment_url($attachment_id).'" target="_blank" rel="noopener noreferrer"><img src="'.wp_get_attachment_url( $attach_image_id ).'"/></a>', //投稿内容
			'_thumbnail_id' => $attach_image_id
		);
		
		$post_id = wp_insert_post($post_data);
		if (!$post_id) {
			// エラー処理			
		}
		return;
	}


#ここまで


	public function pigen_insert( $html, $attach_id, $attachment ) { // Insert thumbnail instead of PDF

# テーマのfunction.php

/**
 * カスタム画像 上左右中央を基準にトリミング
 */
function my_awesome_image_resize_dimensions( $payload, $orig_w, $orig_h, $dest_w, $dest_h, $crop ){
	if( false ) return $payload;

	if ( $crop ) {
		$aspect_ratio = $orig_w / $orig_h;
		$new_w = min($dest_w, $orig_w);
		$new_h = min($dest_h, $orig_h);

		if ( !$new_w ) $new_w = intval($new_h * $aspect_ratio);
		if ( !$new_h ) $new_h = intval($new_w / $aspect_ratio);

		$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
		$crop_w = round($new_w / $size_ratio);
		$crop_h = round($new_h / $size_ratio);

		$s_x = ($orig_w - $crop_w) / 2;
		$s_y = 0;
	} else {
		$crop_w = $orig_w;
		$crop_h = $orig_h;

		$s_x = ($orig_w - $crop_w) / 2;
		$s_y = 0;

		list( $new_w, $new_h ) = wp_constrain_dimensions( $orig_w, $orig_h, $dest_w, $dest_h );
	}

	if ( $new_w >= $orig_w && $new_h >= $orig_h ) return false;
	return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
add_filter( 'image_resize_dimensions', 'my_awesome_image_resize_dimensions', 10, 6 );

# テーマのスタイルシート

/*著者情報、投稿のサムネイル、コメント、カテゴリタイトルを消す*/
.byline,
.single-post .post-thumbnail,
#comments,
.page-title,
.copyright-info,
.page-id-1021 h1.entry-title {
	display: none;
}
