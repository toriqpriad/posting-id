/*
  RoxyFileman - web based file manager. Ready to use with CKEditor, TinyMCE.
  Can be easily integrated with any other WYSIWYG editor or CMS.

  Copyright (C) 2013, RoxyFileman.com - Lyubomir Arsov. All rights reserved.
  For licensing, see LICENSE.txt or http://RoxyFileman.com/license

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

  Contact: Lyubomir Arsov, liubo (at) web-lobby.com
  */
  function FileSelected(file) {
    /**
     * file is an object containing following properties:
     *
     * fullPath - path to the file - absolute from your site root
     * path - directory in which the file is located - absolute from your site root
     * size - size of the file in bytes
     * time - timestamo of last modification
     * name - file name
     * ext - file extension
     * width - if the file is image, this will be the width of the original image, 0 otherwise
     * height - if the file is image, this will be the height of the original image, 0 otherwise
     *
     */
    // alert('"' + file.fullPath + "\" selected.\n To integrate with CKEditor or TinyMCE change INTEGRATION setting in conf.json. For more details see the Installation instructions at http://www.roxyfileman.com/install.");
    var name = file.name;
    var fullpath = $(location).attr('protocol') + '//' + $(location).attr('hostname') + file.fullPath;
    var active_action = $(window.parent.document).find('#active_action').val();    
    if (active_action == 'image') {
      var my_html = "<div class='col-md-4 image_container'><div class='panel panel-default'><div class='panel-heading'><div class='radio-inline'><input type='radio' id='set_active'  name='thumbnail' onclick='setToThumbnail(&quot;" + name + "&quot;)'>&nbsp;Jadikan sebagai gambar depan </div></div><br><div class='panel-body'><img src='" + fullpath + "'  class='image_data img-responsive center-block' value='" + name + "' style='height:250px; width:325px;margin-right:15px;margin-bottom:15px;'><button class='btn btn-block btn-default' onclick='deleteThisImage(this)' style='margin-bottom:10px;'>Hapus</button></div>";
      $(window.parent.document).find('#image_contents').append(my_html);
    } else {
      var my_html = "<div class='col-md-4 image_container'><div class='panel panel-default'><div class='panel-body'><img src='" + fullpath + "'  class='sketch_data  img-responsive center-block' value='" + name + "' style='height:250px; width:325px;margin-right:15px;margin-bottom:15px;'><input type='text' class='form-control image_title' placeholder='Judul Gambar'><button class='btn btn-block btn-default' onclick='deleteThisImage(this)' style='margin-bottom:10px;'>Hapus</button></div></div></div>";
      $(window.parent.document).find('#sketch_contents').append(my_html);
    }
    window.parent.filemanagerModalClose();
  }

  function GetSelectedValue() {
    /**
     * This function is called to retrieve selected value when custom integration is used.
     * Url parameter selected will override this value.
     */
     return "";
   }