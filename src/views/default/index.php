<?php
/**
 * Created by Navatech.
 * @project yii2-roxymce
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    15/02/2016
 * @time    2:56 CH
 * @var string $roxyMceUrl
 */
$roxyMceAsset = \navatech\roxymce\RoxyMceAsset::register($this);
$this->registerJs('var roxyMceAsset = "' . $roxyMceAsset->baseUrl . '";var roxyMceUrl = "' . $roxyMceUrl . '";', 1);
\yii\jui\JuiAsset::register($this);
\navatech\roxymce\JqueryDateFormatAsset::register($this);
\yii\bootstrap\BootstrapAsset::register($this);
\navatech\roxymce\FontAwesomeAsset::register($this);
?>
<div class="col-sm-12" id="wrapper">
	<div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pnlDirs" id="dirActions">
			<div class="actions">
				<button type="button" class="btn btn-sm btn-primary" onclick="addDir()" data-lang-v="CreateDir" data-lang-t="T_CreateDir">
					<i class="fa fa-plus-square"></i></button>
				<button type="button" class="btn btn-sm btn-warning" onclick="renameDir()" data-lang-t="T_RenameDir" data-lang-v="RenameDir">
					<i class="fa fa-pencil-square"></i></button>
				<button type="button" class="btn btn-sm btn-danger" onclick="deleteDir()" data-lang-t="T_DeleteDir" data-lang-v="DeleteDir">
					<i class="fa fa-trash"></i></button>
			</div>
			<div id="pnlLoadingDirs">
				<span>Loading directories...</span><br>
				<img src="<?= $roxyMceAsset->baseUrl ?>/images/loading.gif" title="Loading directory tree, please wait...">
			</div>
			<div class="scrollPane">
				<ul id="pnlDirList"></ul>
			</div>

		</div>
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" id="fileActions">
			<input type="hidden" id="hdViewType" value="list">
			<input type="hidden" id="hdOrder" value="asc">
			<div class="actions">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<button type="button" class="btn btn-sm btn-primary" onclick="addFileClick()" data-lang-v="AddFile" data-lang-t="T_AddFile">
							<i class="fa fa-plus"></i></button>
						<button type="button" class="btn btn-sm btn-info" onclick="previewFile()" data-lang-v="Preview" data-lang-t="T_Preview">
							<i class="fa fa-search"></i></button>
						<button type="button" class="btn btn-sm btn-warning" onclick="renameFile()" data-lang-v="RenameFile" data-lang-t="T_RenameFile">
							<i class="fa fa-pencil"></i></button>
						<button type="button" class="btn btn-sm btn-success" onclick="downloadFile()" data-lang-v="DownloadFile" data-lang-t="T_DownloadFile">
							<i class="fa fa-download"></i></button>
						<button type="button" class="btn btn-sm btn-danger" onclick="deleteFile()" data-lang-v="DeleteFile" data-lang-t="T_DeleteFile">
							<i class="fa fa-trash"></i></button>
						<button type="button" class="btn btn-sm btn-success" onclick="setFile()" data-lang-v="SelectFile" data-lang-t="T_SelectFile">
							<i class="fa fa-check"></i></button>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<select onchange="sortFiles()" class="form-control input-sm">
							<option value="name" data-lang="Name_asc">&uarr;&nbsp;&nbsp;Name</option>
							<option value="size" data-lang="Size_asc">&uarr;&nbsp;&nbsp;Size</option>
							<option value="time" data-lang="Date_asc">&uarr;&nbsp;&nbsp;Date</option>
							<option value="name_desc" data-lang="Name_desc">&darr;&nbsp;&nbsp;Name</option>
							<option value="size_desc" data-lang="Size_desc">&darr;&nbsp;&nbsp;Size</option>
							<option value="time_desc" data-lang="Date_desc">&darr;&nbsp;&nbsp;Date</option>
						</select>
					</div>
					<div class="col-sm-3">
						<button type="button" class="btn btn-default" onclick="switchView('list')" data-lang-t="T_ListView">
							<i class="fa fa-list"></i></button>
						<button type="button" class="btn btn-default" onclick="switchView('thumb')" data-lang-t="T_ThumbsView">
							<i class="fa fa-picture-o"></i></button>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group form-inline">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" placeholder="Search for..." onkeyup="filterFiles()" onchange="filterFiles()">
									<span class="input-group-btn">
									    <button class="btn btn-default" type="button"><i class="fa fa-search"></i>
									    </button>
									</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="pnlFiles">
				<div class="scrollPane">
					<div id="pnlLoading">
						<span data-lang="LoadingFiles">Loading files...</span><br>
						<img src="<?= $roxyMceAsset->baseUrl ?>/images/loading.gif" title="Loading files, please wait...">
					</div>
					<div id="pnlEmptyDir" data-lang="DirIsEmpty">
						This folder is empty
					</div>
					<div id="pnlSearchNoFiles" data-lang="NoFilesFound">
						No files found
					</div>
					<ul id="pnlFileList"></ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row bottomLine">
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			&nbsp;&nbsp;&nbsp;<a href="http://www.roxyfileman.com" target="_blank">&copy; 2013 -
				<span id="copyYear"></span> RoxyFileman</a>
		</div>
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div id="pnlStatus">Status bar</div>
		</div>
	</div>
</div>

<!-- Forms and other components -->
<iframe name="frmUploadFile" width="0" height="0" style="display:none;border:0;"></iframe>
<div id="dlgAddFile">
	<form name="addfile" id="frmUpload" method="post" target="frmUploadFile" enctype="multipart/form-data">
		<input type="hidden" name="d" id="hdDir"/>
		<div class="form"><br/>
			<input type="file" name="files[]" id="fileUploads" onchange="listUploadFiles(this.files)" multiple="multiple"/>
			<div id="uploadResult"></div>
			<div class="uploadFilesList">
				<div id="uploadFilesList"></div>
			</div>
		</div>
	</form>
</div>
<div id="menuFile" class="contextMenu">
	<a href="#" onclick="setFile()" data-lang="SelectFile" id="mnuSelectFile">Select</a>
	<hr>
	<a href="#" onclick="previewFile()" data-lang="Preview" id="mnuPreview">Preview</a>
	<hr>
	<a href="#" onclick="downloadFile()" data-lang="DownloadFile" id="mnuDownload">Download</a>
	<hr>
	<a href="#" onclick="return pasteToFiles(event, this)" data-lang="Paste" class="paste pale" id="mnuFilePaste">Paste</a>
	<hr>
	<a href="#" onclick="cutFile()" data-lang="Cut" id="mnuFileCut">Cut</a>
	<hr>
	<a href="#" onclick="copyFile()" data-lang="Copy" id="mnuFileCopy">Copy</a>
	<hr>
	<a href="#" onclick="renameFile()" data-lang="RenameFile" id="mnuRenameFile">Rename</a>
	<hr>
	<a href="#" onclick="deleteFile()" data-lang="DeleteFile" id="mnuDeleteFile">Delete</a><!-- hr>
  <a href="#" onclick="fileProperties()" id="mnuProp">Properties</a -->
</div>
<div id="menuDir" class="contextMenu">
	<a href="#" onclick="downloadDir()" data-lang="Download" id="mnuDownloadDir">Download</a>
	<hr>
	<a href="#" onclick="addDir()" data-lang="T_CreateDir" id="mnuCreateDir">Create new</a>
	<hr>
	<a href="#" onclick="return pasteToDirs(event, this)" data-lang="Paste" class="paste pale" id="mnuDirPaste">Paste</a>
	<hr>
	<a href="#" onclick="cutDir()" data-lang="Cut" id="mnuDirCut">Cut</a>
	<hr>
	<a href="#" onclick="copyDir()" data-lang="Copy" id="mnuDirCopy">Copy</a>
	<hr>
	<a href="#" onclick="renameDir()" data-lang="RenameDir" id="mnuRenameDir">Rename</a>
	<hr>
	<a href="#" onclick="deleteDir()" data-lang="DeleteDir" id="mnuDeleteDir">Delete</a>
</div>
<div id="pnlRenameFile" class="dialog">
	<span class="name"></span><br>
	<input type="text" id="txtFileName">
</div>
<div id="pnlDirName" class="dialog">
	<span class="name"></span><br>
	<input type="text" id="txtDirName">
</div>
