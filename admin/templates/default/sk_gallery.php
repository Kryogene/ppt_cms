<?PHP

class sk_gallery
{
  
  function search_table_albums( $rows, $nav="" )
	{
		
		$HTML = <<<HTML
		<table class="search_table">
			<tr>
				<th>
					Title
				</th>
				<th>
					Created By
				</th>
				<th>
					Description
				</th>
				<th>
					Options
				</th>
			</tr>
			{$rows}
			<tr>
			<td colspan=6>
			{$nav}
			</td>
			</tr>
		</table>
HTML;
		return $HTML;
		
	}
	
	function search_table_photos( $rows, $nav="" )
	{
		
		$HTML = <<<HTML
		<table class="search_table">
			<tr>
				<th>
					Title
				</th>
				<th>
					Uploaded By
				</th>
				<th>
					Image
				</th>
				<th>
					Album
				</th>
				<th>
					Description
				</th>
				<th>
					Options
				</th>
			</tr>
			{$rows}
			<tr>
			<td colspan=6>
			{$nav}
			</td>
			</tr>
		</table>
HTML;
		return $HTML;
		
	}
  
  function search_row_albums( $data, $options )
	{
		$HTML = <<<HTML
			<tr>
				<td>
					{$data['album_title']}
				</td>
				<td>
					{$data['created_by']}
				</td>
				<td>
					{$data['album_description']}
				</td>
				<td>
					{$options}
				</td>
			</tr>
HTML;
		return $HTML;
		
	}
	
	function modify_albums_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=gallery&albums&modify&id={$id}">
			<img src="images/icons/modify.png" alt="Modify" title="Modify">
		</a>
HTML;
		return $HTML;
	}
	
	function delete_albums_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=gallery&albums&delete&id={$id}">
			<img src="images/icons/delete.png" alt="Delete" title="Delete">
		</a>
HTML;
		return $HTML;
	}
	
	function search_row_photos( $data, $options )
	{
		
		$HTML = <<<HTML
			<tr>
				<td>
					{$data['photo_title']}
				</td>
				<td>
					{$data['created_by']}
				</td>
				<td>
					<img src="{$data['img']}" alt="{$data['photo_title']}" title="{$data['photo_title']}">
				</td>
				<td>
					{$data['album_title']}
				</td>
				<td>
					{$data['photo_description']}
				</td>
				<td>
					{$options}
				</td>
			</tr>
HTML;
		return $HTML;
		
	}
		
	function modify_photos_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=gallery&photos&modify&id={$id}">
			<img src="images/icons/modify.png" alt="Modify" title="Modify">
		</a>
HTML;
		return $HTML;
	}
	
	function delete_photos_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=gallery&photos&delete&id={$id}">
			<img src="images/icons/delete.png" alt="Delete" title="Delete">
		</a>
HTML;
		return $HTML;
	}
	
	public function modifyAlbumTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=gallery&search&albums">
		{$fields['id']}
			<table class="dialog no_border form">
				<tr>
					<td>
						Title:
					</td>
					<td>
						{$fields['album_title']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Description:
						<p>
							{$fields['album_description']}
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="modify_album" value="Modify">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
	
	public function createAlbumTable()
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=gallery&search&albums">
			<table class="dialog no_border form">
				<tr>
					<td>
						Title:
					</td>
					<td>
						<input type="text" name="album_title">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Description:
						<p>
							<textarea name="album_description"></textarea>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="create_album" value="Create">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
	
	public function modifyPhotoTable( $fields, $img_src )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=gallery&photos&search" enctype="multipart/form-data">
		{$fields['id']}
			<table class="dialog no_border form">
				<tr>
					<td>
						Title:
					</td>
					<td>
						{$fields['photo_title']}
					</td>
				</tr>
				<tr>
				<tr>
					<td>
						Album:
					</td>
					<td>
						{$fields['album_id']}
					</td>
				</tr>
				<tr>
					<td>
						Image:
					</td>
					<td>
						{$fields['img_upload']}<br>
							<span id="list">
								<figure class="fig">
									<img class="thumb" src="{$img_src}" id="uploaded_img">
								</figure>
							</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Description:
						<p>
							{$fields['photo_description']}
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="modify_photo" value="Modify">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
	
	public function uploadPhotoTable($fields, $max_upload, $max_post)
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=gallery&search&photos" enctype="multipart/form-data">
			<table class="dialog no_border form">
				<tr>
					<td>
						Album:
					</td>
					<td>
						{$fields['album_id']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Upload:
						<p>
							<span style="font-size: 9px; font-style: italic;">Photos cannot be larger than {$max_upload} each or accumulate larger than {$max_post}!<br>
							{$fields['img_upload']}<br>
							<span id="list"></span>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span id="size">0MB</span> / <span>{$max_post}</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="upload_photos" value="Upload">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
}

?>