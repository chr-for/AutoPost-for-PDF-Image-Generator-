/*
 * プラグイン　PDF Image Generator　追加部分
 */

/** function pigen_attachment 内に自動投稿用関数の呼び出しを追加 **/
public function pigen_attachment( $attachment_id ){ // Generate thumbnail from PDF
/*
 * 途中省略
 */

				$return = $thumbnail_id;
				
				/** PDF自動投稿用関数呼び出し **/
				$this->pdf_auto_post($attachment_id);
			} 
		}
		if ( empty( $return ) ) $return = false;
		return $return;
	}

  /** PDF自動投稿用関数 **/
	public function pdf_auto_post($attachment_id){
		$attachment = get_post( $attachment_id );
		$attach_image_id = get_post_meta( $attachment_id, '_thumbnail_id', true );
		$new_post_title = esc_attr( get_the_title( $attachment_id ) );

		/** ファイル名（「[通信名]+[号数].pdf」の形式）を判定し、号数を読み取って、記事のタイトルを生成 **/
		if (preg_match('/alpha/', $new_post_title)){
			preg_match('/\d{1,4}/', $new_post_title, $num_match); 
			$new_post_title = "アルファ".$num_match[0]."号";
			$cat_id = 3; //カテゴリー分け
		}else if (preg_match('/beta/', $new_post_title)){
			preg_match('/\d{1,4}/', $new_post_title, $num_match);
			$new_post_title = "ベータ".$num_match[0]."号";
			$cat_id = 4;
		}else if (preg_match('/gamma/', $new_post_title)){
			$new_post_title = "ガンマ"; //号数が不要の場合
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

