<script type="text/javascript">
var opts = {
	node: '<?php echo $this -> createAbsoluteUrl("admin/category/node", array('pid' => '__pid__', 'lang_id' => '__lang_id__')); ?>',
	websites: '<?php echo $this -> createAbsoluteUrl("admin/url/index", array('type'=>'category', 'category_id' => '__id__')); ?>',
	create: '<?php echo $this -> createAbsoluteUrl("admin/category/create") ?>',
	update: '<?php echo $this -> createAbsoluteUrl("admin/category/update") ?>',
	remove: '<?php echo $this -> createAbsoluteUrl("admin/category/remove") ?>',
	move: '<?php echo $this -> createAbsoluteUrl("admin/category/move") ?>',
	drive_image: '<?php echo $this -> getThemeUrl() ?>/images/root.png',
	folder_image: '<?php echo $this -> getThemeUrl() ?>/images/folder.png',
	lang_id: '<?php echo $root -> lang_id; ?>'
};

var tree_lang = {
	empty_catname: "<?php echo Yii::t("category", "Category name can't be blank") ?>",
	cant_rename_root: "<?php echo Yii::t("category", "Can't rename root category") ?>",
	cant_remove_root: "<?php echo Yii::t("category", "Can't remove root category") ?>",
	cant_remove_not_empty: "<?php echo Yii::t("category", "Can't remove not empty category") ?>",
	realy_delete: "<?php echo Yii::t("category", "Are you sure you want to remove {Category} category?") ?>",
	root: "<?php echo Yii::t("category", "Root") ?>",
	enter_title: "<?php echo Yii::t("category", "Enter category title") ?>"
}


function t(key, replacement) {
	var phrase = tree_lang[key];
	if(typeof(phrase) == "undefined")
		return key;
	if(typeof(replacement) !== "object")
		return phrase;
	for (var i in replacement) {
		phrase = phrase.replace(i, replacement[i]);
	}
	return phrase;
}

var rollback;
var rootNodeID = 'node_' + <?php echo $root -> id ?>;

function isRoot(node) {
	return node.attr("id") == rootNodeID;
}

function formatUrl(url, params) {
	var url = url.replace(/__(\w+)__/g, function(search, key) {
		return params[key] || search;
	});
	return url;
}

$(function () {
	// TO CREATE AN INSTANCE
	// select the tree container using jQuery
	$("#tree")
		// call `.jstree` with the options object
		.jstree({
			"plugins": ["themes","json_data","ui","crrm","dnd","types"],
			"json_data" : {
					"data" : [{
						"data" : t("root"),
						"state" : "closed",
						"attr" : { "rel" : "drive", "id" : rootNodeID},
						"metadata" : { "id" : "<?php echo $root -> id ?>" }
					}],
					ajax: {
						url : function(n) {
							var params = {
								pid : n.data("id"),
								lang_id : opts.lang_id
							};
							var url = formatUrl(opts.node, params);
							console.log(url);
							return url;
						}
					}
        },
			"core" : { "initially_open" : [rootNodeID] },
			"ui" : { "select_multiple_modifier" : false },
			"types" : {
				// I set both options to -2, as I do not need depth and children count checking
				// Those two checks may slow jstree a lot, so use only when needed
				"max_depth" : -2,
				"max_children" : -2,
				// I want only `drive` nodes to be root nodes
				// This will prevent moving or creating any other type as a root node
				"valid_children" : [ "drive" ],
				"types" : {
					// The `folder` type
					"folder" : {
						// can have files and other folders inside of it, but NOT `drive` nodes
						"valid_children" : [ "default", "folder" ],
						"icon" : {
							"image" : opts.folder_image
						}
					},
					// The `drive` nodes
					"drive" : {
						// can have files and folders inside, but NOT other `drive` nodes
						"valid_children" : [ "default", "folder" ],
						"icon" : {
							"image" : opts.drive_image
						},
						// those prevent the functions with the same name to be used on `drive` nodes
						// internally the `before` event is used
						"start_drag" : false,
						"move_node" : false,
						"delete_node" : false,
						"remove" : false
					}
				}
			}

		})
		// When the tree is loaded
		.bind("loaded.jstree", function (e, data) {
			data.inst.select_node("#" + rootNodeID);
		})
		.bind("select_node.jstree", function(e, data) {
			var node = data.rslt.obj;
			if(isRoot(node)) {
				$("#properties").hide();
				return false;
			}
			$("#category_id").val(node.data("id"));
			$("#category_title").val(node.data("title"));
			$("#category_slug").val(node.data("slug"));
			$("#category_visible").attr("checked", (node.data("visible") == 1 ? true : false));
			$("#cat_websites").attr("href", formatUrl(opts.websites, {id: node.data("id")}));
			$("#properties").show();
		})
		.bind("move_node.jstree", function(e, data) {
			/*
			* data.rslt.o - the object which is moved
			* data.rslt.or - previous object (if exists) IF moved from top to the bottom then undefined
			* data.rslt.np - parent id
			*/

			var params = {
				node_id: data.rslt.o.data("id"),
				previous_id: data.rslt.or.data("id"),
				parent_id: data.rslt.np.data("id")
			};

			rollback = data.rlbk;

			$.post(opts.move, params, function(d) {
				if(d.success) {
					consoleObject(d.success, "success");
				} else {
					consoleObject(d.error, "error");
					$.jstree.rollback(data.rlbk);
				}
			}, "JSON");

		})
		.bind("create.jstree", function(e, data) {
			var params = {
				Category : {
					title: data.rslt.name,
					lang_id: opts.lang_id,
					slug: data.rslt.name
				},
				pid : data.rslt.parent.data("id")
			}
			rollback = data.rlbk;

			$.post(opts.create, params, function(d) {
				if(d.success) {
					consoleString(d.success, "success");
					$(data.rslt.obj).data("id", d.id);
					$(data.rslt.obj).data("title", d.title);
					$(data.rslt.obj).data("slug", d.slug);
				} else {
					consoleObject(d.error, "error");
					$.jstree.rollback(data.rlbk);
				}
			}, "JSON");
		});
});

$(function () {
    $( document ).ajaxError(function(event, jqXHR, textStatus, errorThrown) {
        if(rollback) {
            $("#tree").jstree("rollback", rollback);
        }
        $.jstree.rollback(rollback);
        consoleString(jqXHR.responseText, "error");
    });

});


function consoleString(message, type) {
	var types = {
		"error" : "danger",
		"success" : "success",
		"warning" : "warning"
	};
	$("#notifications").prepend('<div class="alert alert-'+ types[type] +'">'+ message +'</div>');
}

function consoleObject(obj, type) {
	if(typeof(obj) != "object") {
		consoleString(obj, type);
		return true;
	}

	for(var i in obj) {
		if(typeof(obj[i]) == "object")
			consoleObject(obj[i], type);
		else
			consoleString(obj[i], type);
	}
}

$(function () {

	$("#update").click(function() {
		var
			node = $.jstree._reference("#tree").get_selected(),
			parent = $.jstree._reference("#tree")._get_parent(node),
			data = $("#category-properties").serializeArray();

		data.push({
			"name" : "id",
			"value" : node.data("id")
		}, {
			"name" : "pid",
			"value" : parent.data("id")
		});

		//console.log(data);

		$.post(opts.update, data, function(d) {
			//console.log(d);
			//return;
			if(d.success) {
				node.data("title", d.title);
				node.data("slug", d.slug);
				$.jstree._reference("#tree").rename_node(node, d.title),
				consoleObject(d.success, "success");
			} else {
				consoleObject(d.error, "error");
			}
		});
		return false;
	});

	$("#create_category").click(function() {
		$("#tree").jstree("create", null, "first", {
			attr : {
				rel: "folder"
			},
			data: t("enter_title")
		});
	});

	$("#remove_category").click(function() {
		var selected = $("#tree").jstree("get_selected");


		if(typeof(selected.data("id")) == "undefined") {
			return false;
		}

		/*if(selected.attr("state") == "closed") {
			consoleString(t("cant_remove_not_empty"), "warning");
			return false;
		}*/

		if(!confirm(t("realy_delete", {"{Category}" : $.trim($(selected).data('title'))}))) {
			return false;
		}

		$.post(opts.remove, {id:selected.data("id"), title: selected.data("title")}, function(d) {
            if(d.success) {
				$("#tree").jstree("delete_node", selected);
				$("#properties").hide();
				consoleString(d.success, "success");
			} else {
				consoleString(d.error, "error");
                $("#tree").jstree("rollback", rollback);
			}
		}, "JSON");

		return false;
	});

});
</script>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo Yii::t("category", "Category properties"); ?></div>
            <div class="panel-body">
                <div id="properties">
                    <form class="form-horizontal" id="category-properties">

                        <div class="form-group">
                            <label for="category_id" class="col-sm-4 control-label"><?php echo Yii::t("category", "Category ID") ?></label>
                            <div class="col-sm-8">
                                <input type="text" readonly name="id" id="category_id" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category_title" class="col-sm-4 control-label"><?php echo Yii::t("category", "Title") ?></label>
                            <div class="col-sm-8">
                                <input type="text" name="Category[title]" id="category_title" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category_slug" class="col-sm-4 control-label"><?php echo Yii::t("category", "Slug") ?></label>
                            <div class="col-sm-8">
                                <input type="text" name="Category[slug]" id="category_slug" class="form-control">
                            </div>
                        </div>

                        <?php if(Yii::app()->user->checkAccess('admin_category_update')): ?>
                        <button id="update" class="btn btn-primary"><?php echo Yii::t("category", "Update") ?></button>
                        <?php endif; ?>

                        <?php if(Yii::app()->user->checkAccess('admin_url_index')): ?>
                        <a href="#" target="blank" id="cat_websites" class="btn btn-default"><?php echo Yii::t("category", "Show websites in this category") ?></a>
                        <?php endif; ?>
                    </form>

                </div>
            </div>
        </div>

    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo Yii::t("category", "Notifications"); ?></div>
            <div class="panel-body">
                <div id="notifications"></div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12">
        <?php if(Yii::app()->user->checkAccess('admin_category_create')): ?>
            <button id="create_category" class="btn btn-info"><?php echo Yii::t("category", "Create") ?></button>
        <?php endif; ?>
        <?php if(Yii::app()->user->checkAccess('admin_category_remove')): ?>
            <button id="remove_category" class="btn btn-warning"><?php echo Yii::t("category", "Remove") ?></button>
        <?php endif; ?>
        <br/><br/>
        <div id="tree"></div>
    </div>
</div>