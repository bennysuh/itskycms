<?php if (!defined('THINK_PATH')) exit();?><div class="col-sm-12">
    <div class="widget-box">
        <div class="widget-header header-color-green">
            <h4 class="lighter smaller">Browse Files</h4>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">
                <div id="menu-tree" class="tree"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/itskycms/Public/bootstrap/js/fuelux.tree.js"></script><script type="text/javascript" src="/itskycms/Public/bootstrap/js/fuelux.data.js"></script>
<script type="text/javascript">
    var DataSourceTree = function(options) {
	this._data 	= options.data;
	this._delay = options.delay;
    };

    DataSourceTree.prototype.data = function(options, callback) {
	var self = this;
	var $data = null;

	if(!("name" in options) && !("type" in options)){
            $data = this._data;//the root tree
            callback({ data: $data });
            return;
	}
	else if("type" in options && options.type == "folder") {
            if("additionalParameters" in options && "children" in options.additionalParameters)
                    $data = options.additionalParameters.children;
            else $data = {}//no data
	}
	
	if($data != null)//this setTimeout is only for mimicking some random delay
		setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);
    };

    var tree_data = {
	'pictures' : {name: '<i class="glyphicon glyphicon-book dark"></i> Pictures', type: 'folder', 'icon-class':'glyphicon'}	,
	'music' : {name: 'Music', type: 'folder', 'icon-class':'glyphicon orange'}	,
	'video' : {name: 'Video', type: 'folder', 'icon-class':'glyphicon blue'}	,
	'documents' : {name: 'Documents', type: 'folder', 'icon-class':'glyphicon green'}	,
	'backup' : {name: 'Backup', type: 'folder','icon-class':'glyphicon'}	,
	'readme' : {name: '<i class="glyphicon glyphicon-file grey"></i> ReadMe.txt', type: 'item'},
	'manual' : {name: '<i class="glyphicon glyphicon-book blue"></i> Manual.html', type: 'item'}
    };
    tree_data['music']['additionalParameters'] = {
	'children' : [
            {name: '<i class="glyphicon glyphicon-music blue"></i> song1.ogg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-music blue"></i> song2.ogg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-music blue"></i> song3.ogg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-music blue"></i> song4.ogg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-music blue"></i> song5.ogg', type: 'item'}
	]
    };
    tree_data['video']['additionalParameters'] = {
	'children' : [
            {name: '<i class="glyphicon glyphicon-film blue"></i> movie1.avi', type: 'item'},
            {name: '<i class="glyphicon glyphicon-film blue"></i> movie2.avi', type: 'item'},
            {name: '<i class="glyphicon glyphicon-film blue"></i> movie3.avi', type: 'item'},
            {name: '<i class="glyphicon glyphicon-film blue"></i> movie4.avi', type: 'item'},
            {name: '<i class="glyphicon glyphicon-film blue"></i> movie5.avi', type: 'item'}
	]
    };
    tree_data['pictures']['additionalParameters'] = {
	'children' : {
            'wallpapers' : {name: 'Wallpapers', type: 'folder', 'icon-class':'glyphicon pink'},
            'camera' : {name: 'Camera', type: 'folder', 'icon-class':'glyphicon pink'}
	}
    };
    tree_data['pictures']['additionalParameters']['children']['wallpapers']['additionalParameters'] = {
	'children' : [
            {name: '<i class="glyphicon glyphicon-picture green"></i> wallpaper1.jpg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-picture green"></i> wallpaper2.jpg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-picture green"></i> wallpaper3.jpg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-picture green"></i> wallpaper4.jpg', type: 'item'}
	]
    };
    tree_data['pictures']['additionalParameters']['children']['camera']['additionalParameters'] = {
	'children' : [
            {name: '<i class="glyphicon glyphicon-picture green"></i> photo1.jpg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-picture green"></i> photo2.jpg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-picture green"></i> photo3.jpg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-picture green"></i> photo4.jpg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-picture green"></i> photo5.jpg', type: 'item'},
            {name: '<i class="glyphicon glyphicon-picture green"></i> photo6.jpg', type: 'item'}
	]
    };


    tree_data['documents']['additionalParameters'] = {
	'children' : [
            {name: '<i class="glyphicon glyphicon-file red"></i> document1.pdf', type: 'item'},
            {name: '<i class="glyphicon glyphicon-file grey"></i> document2.doc', type: 'item'},
            {name: '<i class="glyphicon glyphicon-file grey"></i> document3.doc', type: 'item'},
            {name: '<i class="glyphicon glyphicon-file red"></i> document4.pdf', type: 'item'},
            {name: '<i class="glyphicon glyphicon-file grey"></i> document5.doc', type: 'item'}
	]
    };

    tree_data['backup']['additionalParameters'] = {
	'children' : [
            {name: '<i class="glyphicon glyphicon-briefcase brown"></i> backup1.zip', type: 'item'},
            {name: '<i class="glyphicon glyphicon-briefcase brown"></i> backup2.zip', type: 'item'},
            {name: '<i class="glyphicon glyphicon-briefcase brown"></i> backup3.zip', type: 'item'},
            {name: '<i class="glyphicon glyphicon-briefcase brown"></i> backup4.zip', type: 'item'}
	]
    };
    var treeDataSource = new DataSourceTree({data: tree_data});
    $('#menu-tree').ace_tree({
            dataSource: treeDataSource,
            loadingHTML:'<div class="tree-loading"><i class="glyphicon glyphicon-refresh icon-spin blue"></i></div>',
            'open-icon' : 'glyphicon-chevron-down',
            'close-icon' : 'glyphicon-chevron-right',
            'selectable' : false,
            'selected-icon' : null,
            'unselected-icon' : null
    });
    var pan = '<li><a class="tarmain" href="<?php echo U(CONTROLLER_NAME.'/'.ACTION_NAME);?>"><?php echo L($Think.ACTION_NAME);?></a></li>\n\
<li class="active"><?php echo L('SHOW');?></li>';
    $('#breadcrumbs .breadcrumb li:gt(0)').remove();
    $('#breadcrumbs .breadcrumb').append(pan);
    $('.page-header h1').empty();
    $('.page-header h1').append('<?php echo L($Think.ACTION_NAME);?><small class="glyphicon glyphicon-chevron-right"> <?php echo L('SHOW');?></small>');

    $('a.tarmain').click(function(e){
        $.get( $(this).attr('href'),function(data){
            if($.isPlainObject(data)){
                show_msg(data);
            }else{
                $('#new_content').html(data);
            }
        });
        e.preventDefault();
    });
</script>