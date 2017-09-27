function ge(e) {
    return document.getElementById(e);
}
/*
class Notify {
    constructor() {
        Notification.requestPermission(function(permission){
            console.log('Результат запроса прав:', permission);
            //default — запрос на получение прав не отправлялся
            //granted — пользователь разрешил показывать уведомления
            //denied — пользователь запретил показывать уведомления
            if (permission == "default") {
                
            } else if (permission == "granted") {
                console.log("");
            } else if (permission == "denied") {
                
            }
        });
    }
    create(title, text, tag) {
        var notification = new Notification(title,
            { 
                body: text, 
                dir: 'auto', 
                icon: 'icon.jpg', 
                tag: tag
            }
        );
        notification.onshow = function() {
            console.info("Notification show");
        }
        notification.onclick = function() {
            console.log("click");
        }
        notification.onerror = function() {
            console.log("error");
        }
        notification.onclose = function() {
            console.log("Notification closed");
        }
    }
}
*/
var xml = {
    http: function() {
      var x;
      try {
          x = new ActiveXObject('Msxml2.XMLHTTP');
      } catch (e) {
          try {
            x = new ActiveXObject('Microsoft.XMLHTTP');
          } catch (E) {
            x = false;
          }
      }
     if (!x && typeof XMLHttpRequest != 'undefined') {
          x = new XMLHttpRequest();
      }
      return x;
    }
}

var box = {
    show: function(title, content) {
        var ajax_block = ge("ajax_load_block");
        ajax_block.style.display = "block";
        
        var box = document.createElement("div");
        box.className = "box";
        
        var content_box = document.createElement("div");
        content_box.className = "content-box";
        content_box.innerHTML = "<div class=\"box-title\"><div>"+title+"</div><div class=\"box-close\" onclick=\"box.hide()\">Закрыть</div></div><div class=\"box-content-btn\">"+content+"</div>";
        
        box.appendChild(content_box);
        
        ajax_block.appendChild(box);      
    },
    hide: function() {
        var ajax_block = ge("ajax_load_block");
        ajax_block.innerHTML = "";
        ajax_block.style.display = "none";
    },
}

var ajax = {
    page: function(h, callback=false) {
         history.pushState({link:h}, null, h);
         scroll("");
         
         var block = ge("main");
         var load_bl = ge("ajax_load_block");
         var xhr = xml.http();
         var header_panel_title = ge("header_panel_title");
         var title = ge("title");
         var host  = document.location.host;
         var protocol = document.location.protocol;
         var url_ = protocol + "//" + host;
         
         xhr.open("get", h);
         xhr.onreadystatechange = function() {
           if (xhr.readyState == 4) {
               //title page & header_panel_title
               updateTitle();
               //!end
               load_bl.innerHTML = xhr.responseText;
               block.innerHTML = "";
               var result = ge('ajax_page').innerHTML;
               block.innerHTML = result;
               load_bl.innerHTML = "";

               if (callback) {
               	 callback();
               }
           }
         }
         xhr.send(null);
         return false;
    },
    page_block: function(h) {
         var block = ge("ajax_load_block");
         block.style.display = "block";
         var xhr = xml.http();
         xhr.open("get", h);
         xhr.onreadystatechange = function() {
           if (xhr.readyState == 4) {
               var result = xhr.responseText;
               block.innerHTML = result;
           }
         }
         xhr.send(null);
         return false;
    },
    a: function(url, param) {
        var xhr;
        try {
            xhr = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
            try {
              xhr = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (E) {
              xhr = false;
            }
        }
        if (!xhr && typeof XMLHttpRequest != 'undefined') {
            xhr = new XMLHttpRequest();
        }
    	xhr.open('get', url);
        xhr.onreadystatechange = function() {
    			  if (xhr.readyState == 4) {
    					 if (typeof param == 'undefined') {
    						  return true;
    					 } else if (typeof param['callback'] == 'function') {
    						  param['callback'](xhr.responseText);
    					 }
    					 return true;
    				}
    		}
    		xhr.send(null);
    },
    post: function(param) {
        var xhr;
        try {
            xhr = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
            try {
              xhr = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (E) {
              xhr = false;
            }
        }
        if (!xhr && typeof XMLHttpRequest != 'undefined') {
            xhr = new XMLHttpRequest();
        }
    	xhr.open("post", param['url']);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        xhr.onreadystatechange = function() {
    			  if (xhr.readyState == 4) {
    					 if (typeof param == 'undefined') {
    						  return true;
    					 } else if (typeof param['callback'] == 'function') {
    						  param['callback'](xhr.responseText);
    					 }
    					 return true;
    				}
    		}
        xhr.send(param['data']);
    }
}


var join = {
    reg: function() {
       var login = ge("login").value;
       var pass  = ge("pass").value;
       var status = ge("status_login_reg");
       var error  = ge("error_reg_or_auth");
       if (login.length == 0 || login.length < 6 || pass.length == 0 || pass.length < 6) {
           error.style.display = "block";
           error.innerHTML = "Ошибка!";
        } else {
           error.style.display = "none";
           status.style.color = "#5FB053";
           status.innerHTML = "Обработка ..";
           ajax.post({
               url: "/",
               data: "reg_email=" + login + "&reg_pass=" + pass,
               callback: function(data) {
                    console.log(data);
                    if (data == "Err1") {
                        error.style.display = "block";
                        error.innerHTML = "Ошибка при регистрации!";
                        status.innerHTML = "";
                    } else if (data == "Err2") {
                        error.style.display = "block";
                        error.innerHTML = "Email занят!";
                        status.innerHTML = "";
                    } else 
                       document.location.href = "/registration_info";
               }
           });
        }
    },
    login: function() {
        var login = ge("login").value;
        var pass  = ge("pass").value;
        var status = ge("status_login_reg");
        var error  = ge("error_reg_or_auth");
        if (login.length == 0 || login.length < 6 || pass.length == 0 || pass.length < 6) {
            error.style.display = "block";
            error.innerHTML = "Ошибка!";
        } else {
            error.style.display = "none";
            status.style.color = "#5FB053";
            status.innerHTML = "Обработка ..";
            ajax.post({
                url: "/", 
                data: "auth_email=" + login + "&auth_pass=" + pass,
                callback: function(data) {
                    console.log(data);
                    if (data == "Err1") {
                        error.style.display = "block";
                        status.innerHTML = "";
                        error.innerHTML = "Пользователь не найден или данные введены неверно!";
                    } else if (data == "Err2") {
                        document.location.href = "/accessErrorBlock";    
                    } else if (data == "Err3") {
						document.location.href = "/accessErrorDeleted";
					} else 
                        document.location.href = "/lenta";    
                }
            });
        }
    }
}


var menu = {
    show: function() {
        var icon = ge("icon");
        var m_   = ge("left_panel_fx");
        icon.classList.add("header-icon-close");
        m_.style.height = "145px";
        m_.style.borderBottom = "1px solid #ccc";
        scroll(true);
        icon.setAttribute("onclick", "menu.hide();");
    },
    hide: function() {
        var icon = ge("icon");
        var m_   = ge("left_panel_fx");
        icon.classList.remove("header-icon-close");
        m_.style.height = "0px";
        m_.style.borderBottom = "0px";
        scroll();
        icon.setAttribute("onclick", "menu.show();");
    }
}

var album = {
    processing: function() {
        var upload_progress = ge("upload_progress");
        upload_progress.style.display = "none";
        
        var processing_start = ge("processing_start");
        processing_start.style.display = "block";
        
        var processing_text = ge("processing_text");
        
        var url = "/index.php?act=album&p=previewImageID";
        ajax.a(url, {
           callback: function(data) {
               var previewImageSrcID = data;
               
               processing_text.innerHTML = "Почти готово ..";
               
               var preview_image = ge("preview_image");
               preview_image.src = data;
               
               var preview = ge("preview");
               
               preview_image.onload = function() {
                   processing_start.style.display = "none";
                   preview.style.display = "block";
               }
           } 
        }); 
    },
    upload: function() {
        var preview_text  = ge("preview_text").value;
        var preview_title = ge("preview_title").value;
        var preview_category = ge("preview_category");
        var category;
        
        var preview = ge("preview");
        var processing_start = ge("processing_start");    
        var processing_text = ge("processing_text");
        
        if (preview_category.value == 0) {
            box.show("Информация", "Вы не выбрали категорию, а это значит, что она установится по умолчанию, а именно \"Животные\" . <br/><br/> В дальнейшем Вы сможете также изменить ее.");
        }
        
        category = preview_category.value == 0 ? 1 : preview_category.value;
        
        var url = "/index.php?act=album&p=updateInfo&text=" + preview_text + "&title=" + preview_title + "&category=" + category;
        
        ajax.a(url, {
            callback: function(data) {
                if (data == 1) {
                    preview.style.display = "none";
                    processing_start.style.display = "block";
                    processing_text.innerHTML = "Фотография успешно загружена";
                } else {
                    console.error("[Error] Name error: UPLOAD ERROR.");
                    console.error("[Description] Description error: " + data);
                }
            }
        });
    },
    vote: function(id_post) {
        loading("start");
        var url = "/index.php?act=vote&id_post=" + id_post;
        var ajax_block = ge("ajax_load_block");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                if (data == 1) {
                    confirmBox.info("К сожалениею, нельзя голосать за свои фотографии.");
                } else {
                    ajax_block.innerHTML = data;
                    ajax_block.style.display = "block";
                }
            }
        });
    }
}

function loading(a) {
    var loading_block = ge("loading_block");
    if (a == "start")
       loading_block.style.display = "block";
    else 
       loading_block.style.display = "none";
}


function upload_file(file, bool = false, alb = false) {
    var xhr = xml.http();
    var form = new FormData();
    var btn = ge('btn_upload');
    var url;
    
    if (btn != null) btn.style.display = 'none';
    
    var pr = ge('progress');
    var percent = ge("percent");
    var percent_ = ge("percent_");
    if (pr != null) pr.style.display = "block";
    
    xhr.upload.onprogress = function(event) {
        var total = event.total;
        var load  = event.loaded;
        var progress = ge('progress_line');
        var prof  = load / total * 100;
        
        if (progress != null && percent != null && percent_ != null) {
          progress.style.width = Math.floor(prof) + '%';
          percent.innerHTML = Math.floor(prof) + '%';
          percent_.innerHTML = Math.floor(prof) + '%';
        }
        
        if (Math.floor(prof) == 100) {
            if (!bool) {
              
            } else if (alb) {
                setTimeout(function() {
                    album.processing();
                }, 1000);
            } else {
                setTimeout(function() {
                    photo.closeBox();
                    document.location.reload();
                }, 1000);
            }
        }
    }
    
    xhr.onload = xhr.onerror = function() {
        if (this.status == 200) {
            console.log('success');
        } else {
            console.log('error ' + this.status);
        }
    }
    
    if (alb) url = '/index.php?act=upload&a=newPhoto';
    else url = '/index.php?act=upload&a=photo';
    
    form.append('photo', file);
    xhr.open('POST', url, true);
    xhr.send(form);
}

var photo = {
    openBox: function() {
        var ajax_block = ge("ajax_load_block");
        ajax_block.style.display = "block";
        
        var box = document.createElement("div");
        box.className = "box";
        
        var content_box = document.createElement("div");
        content_box.className = "content-box";
        content_box.innerHTML = "<div class=\"box-title\"><div>Загрузка фотографии</div><div class=\"box-close\" onclick=\"photo.closeBox()\">Закрыть</div></div><div class=\"box-content-btn\">Чтобы загрузка была удачной, Ваш файл не должен превышать 15мб. Поддерживаются все известные форматы: <b>jpg</b>, <b>png</b>, <b>gif</b> . <div class=\"box-btn\"><button class=\"btn\" onclick=\"photo.cl()\" id=\"btn_upload\">Загрузить фотографию</button><div class=\"progress\" id=\"progress\" style=\"display: none\"><div class=\"progress-percent\">Выполнено <span id=\"percent\"></span></div><div class=\"progress-line\" id=\"progress_line\"><div class=\"done-progress-persent\">Выполнено <span id=\"percent_\"></span></div></div></div></div></div>";
        
        box.appendChild(content_box);
        
        ajax_block.appendChild(box);      
    },
    closeBox: function() {
        var ajax_block = ge("ajax_load_block");
        ajax_block.innerHTML = "";
        ajax_block.style.display = "none";
    },
    cl: function() {
        ge("photo").click();
    },
    pageUploadPhotoShow: function() {
        var card_category = ge("card_category");
        var upload_photo_page = ge("upload_photo_page");
        var header_title = ge("header_title");
        
        card_category.style.display = "none";
        upload_photo_page.style.display = "block";
        header_title.innerHTML = "Загрузка фотографии";
        ge("photo").click();  
    },
}

var card = {
    aid: "card_animal",
    view: function(event) {
        var e = event || window.event;
        var target = e.target || e.srsElement;
        var list_element = ["card_animal", "card_eats", "card_people", "card_tech", "card_nature", "card_selfie"];
        var header_title = ge("header_title");
        var container_photo_card = ge("card_category");
        
        if (target.tagName.toLowerCase() != "div") return;
        
        var click_id_card = ge(target.id).parentNode.id;
        
        ge(this.aid).classList.remove("anim-card-click"); 
        
        for (var i = 0; i < list_element.length; i++) {
            if (list_element[i] == click_id_card) continue;    
            ge(list_element[i]).classList.add("anim-card-click");
        }
        
        var pause = setTimeout(function() {
            for (var i = 0; i < list_element.length; i++) {
                if (list_element[i] == click_id_card) continue;    
                ge(list_element[i]).remove();
            }
            
            ge(click_id_card).classList.add("main-card-activity");
            ge(click_id_card).classList.remove("photo-card-category");
            ge(click_id_card).innerHTML = "<div class=\"photo-loaded\" id=\"photo_loaded\"></div>";
            
            container_photo_card.setAttribute("onclick", "");
            
            clearTimeout(pause);
        }, 0);
        
        this.aid = click_id_card;
        
        var url = "";
        
        switch (click_id_card) {
            case "card_animal":
                header_title.innerHTML = "Животные";
                url = "/index.php?act=album&p=loadAlbum&category=1";
                break;
            case "card_eats":
                header_title.innerHTML = "Еда и напитки";
                url = "/index.php?act=album&p=loadAlbum&category=2";
                break;
            case "card_people":
                header_title.innerHTML = "Люди и общество";
                url = "/index.php?act=album&p=loadAlbum&category=3";
                break;
            case "card_tech":
                header_title.innerHTML = "Технологии";
                url = "/index.php?act=album&p=loadAlbum&category=4";
                break;
            case "card_nature":
                header_title.innerHTML = "Природа";
                url = "/index.php?act=album&p=loadAlbum&category=5";
                break;
            case "card_selfie":
                header_title.innerHTML = "Селфи";
                url = "/index.php?act=album&p=loadAlbum&category=6";
                break;
        }
        
        ajax.a(url, {
            callback: function(data) {
                var album_main = ge(click_id_card);
                album_main.innerHTML = data;
            }
        });
        
    }
}

function find(array, value) {
  for (var i = 0; i < array.length; i++) {
    if (array[i] == value) return i;
  }
  return -1;
}

var CONFIRM_DELETE_PHOTO = "CONFIRM_DELETE_PHOTO";
var CONFIRM_UPDATE_INFO  = "CONFIRM_UPDATE_INFO";
var CONFIRM_ALERT_INFO   = "CONFIRM_ALERT_INFO";
var CONFIRM_ALERT_ERROR  = "CONFIRM_ALERT_ERROR";

var confirmBox = {
    init: function(type, cn_title = "", btn_ = true, btn_title = "OK") {
        var title;
        var onclick_;
            
        switch (type) {
            case CONFIRM_DELETE_PHOTO:
                title = "Вы действительно хотите удалить фотографию?";
                onclick_ = "edit.deletePhoto()";
                break; 
            case CONFIRM_UPDATE_INFO:
                title = "Обновить информацию?";
                onclick_ = "edit.updateInfoPhoto()";
                break;
            case CONFIRM_ALERT_INFO:
                title = cn_title;
                break;
            case CONFIRM_ALERT_ERROR:
                title = "Произошла ошибка. Повторите попытку позже.";
                btn_ = false;
                break;
            default:
                break;
        }
        this.show(title, btn_, btn_title, onclick_);
    },
    show: function(title, btn_, btn_title, oncl) {
        var ajax_block = ge("ajax_load_block");
        ajax_block.style.display = "block";
        ajax_block.innerHTML = "";
        
        var cn_box = document.createElement("div");
        cn_box.className = "confirm-box";
        cn_box.id = "confirm_box";
        
        if (btn_) 
            cn_box.innerHTML = "<div class=\"confirm-text-container\"><div class=\"confirm-text\" id=\"confirm_text\">"+ title +"</div></div><div class=\"confirm-footer-btn\"><button class=\"btn-cf btn-op btn-cn\" onclick=\"confirmBox.close()\">отменить</button><button class=\"btn-cf\" onclick=\""+oncl+"\">"+ btn_title +"</button></div>";
        else 
            cn_box.innerHTML = "<div class=\"confirm-text-container\"><div class=\"confirm-text\" id=\"confirm_text\">"+ title +"</div></div><div class=\"confirm-footer-btn\"><button class=\"btn-cf btn-op btn-cn\" onclick=\"confirmBox.close()\">отменить</button></div>";
      
        ajax_block.appendChild(cn_box);  
    },
    close: function() {
        var ajax_block = ge("ajax_load_block");
        ajax_block.style.display = "none";
        ajax_block.innerHTML = "";
        scroll();
    },
    info: function(text) {
        var ajax_block = ge("ajax_load_block");
        ajax_block.style.display = "block";
        ajax_block.innerHTML = "";
        
        var cn_box = document.createElement("div");
        cn_box.className = "confirm-box";
        cn_box.id = "confirm_box";
        
        cn_box.innerHTML = "<div class=\"confirm-text-container\"><div class=\"confirm-text\" id=\"confirm_text\">"+ text +"</div></div><div class=\"confirm-footer-btn\"><button class=\"btn-cf btn-op btn-cn\" onclick=\"confirmBox.close()\">закрыть</button></div>";
      
        ajax_block.appendChild(cn_box);  
    },
    infoVote: function(title, idp) {
        var ajax_block = ge("ajax_load_block");
        ajax_block.style.display = "block";
        ajax_block.innerHTML = "";
        
        var cn_box = document.createElement("div");
        cn_box.className = "confirm-box";
        cn_box.id = "confirm_box";
        
        cn_box.innerHTML = "<div class=\"confirm-text-container\"><div class=\"confirm-text\" id=\"confirm_text\">"+ title +"</div></div><div class=\"confirm-footer-btn\"><button class=\"btn-cf btn-op btn-cn\" onclick=\"confirmBox.close()\">отменить</button><button class=\"btn-cf\" onclick=\"voteComment("+idp+")\">оставить</button></div>";
        ajax_block.appendChild(cn_box);  
    }
} 

var vote = {
    voteTrue: function(idp) {
        var url = "/index.php?act=vote&vote=true&id_post=" + idp;
        loading("start");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                if (data == 0) {
                    confirmBox.infoVote("Ваш голос обработан, желаете оставить комментарий?", idp);
                } else if (data == 2) {
                    confirmBox.info("К сожалению, голосовать ЗА можно только 1 раз.");
                } else {
                    confirmBox.infoVote("Ваш голос обработан, желаете оставить комментарий?", idp);
                }
            }
        });
    },
    voteFalse: function(idp) {
        var url = "/index.php?act=vote&vote=false&id_post=" + idp;
        loading("start");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                if (data == 0) {
                    confirmBox.infoVote("Ваш голос обработан, желаете оставить комментарий?", idp);
                } else if (data == 3) {
                    confirmBox.info("К сожалению, голосовать ПРОТИВ можно только 1 раз.");
                } else {
                    confirmBox.infoVote("Ваш голос обработан, желаете оставить комментарий?", idp);
                }
            }
        });
    },
    comment: function(idp) {
        var ajax_block = ge("ajax_load_block");
        ajax_block.style.display = "none";
       
        loading("start");
        var url = "/index.php?act=voteComment&post_id=" + idp + "&display=comment";
        ajax.a(url, {
            callback: function(data) {
                ajax_block.innerHTML = data;
                loading("stop");
                ajax_block.style.display = "block";
            }
        });
    },
    sendComment: function(idp) {
        var comment_text = ge("vote_comment_text").value;
        if (comment_text.length == 0) {
            ge("vote_comment_text").focus(); 
        } else {
            var url = "/index.php?act=voteComment&textComment=" + comment_text + "&post_id=" + idp;
            loading("start");
            ajax.a(url, {
                callback: function(data) {
                    loading("stop");
                    if (data == 0) {
                        confirmBox.info("Ваш комментарий отправлен.");
                    } else {
                        confirmBox.show(CONFIRM_ALERT_ERROR);
                    }
                }
            });
        }
    }
}

function voteComment(idp) {
    vote.comment(idp);
}



var editID;
var edit = {
    showPanel: function(id) {
        editID = id;
        var menu_list = ge("menu_list_" + id);
        var spl = ge("spl_" + id);
        
        if (menu_list == null) return;
        
        spl.setAttribute("onclick", "edit.hidePanel(" + id + ")");
        menu_list.style.opacity = "1";
        menu_list.style.zIndex = "0";
    },
    hidePanel: function(id) {
        var menu_list = ge("menu_list_" + id);
        var spl = ge("spl_" + id);
        
        if (menu_list == null) return;
        
        spl.setAttribute("onclick", "edit.showPanel(" + id + ")");
        menu_list.style.opacity = "0";
        menu_list.style.zIndex = "-1";
    },
    deletePhoto: function() {
        var url = "/index.php?act=album&p=deletePhoto&id=" + editID;
        confirmBox.info("Операция выполняется, пожалуйста, подождите.");
        ajax.a(url, {
            callback: function(data) {
                if (data == 0) {
                   confirmBox.init(CONFIRM_ALERT_INFO, "Фотография успешно удалена.", false);
                   console.log("Element id: album_photo_" + editID);
                   ge("album_photo_" + editID).remove();
                   console.info("[DELETE] Delete photo: album_photo_" + editID);
                } else {
                   confirmBox.init(CONFIRM_ALERT_ERROR);
                }
            }
        });
    },
    updateInfoPhoto: function() {}
}

var feedback = {
    showBox: function(display) {
        let ajax_block = ge("ajax_load_block");
        ajax_block.innerHTML = "";
        ajax_block.style.display = display;
        
        let report_block = document.createElement("div");
        report_block.className = "report-block";
        
        let header_report_block = document.createElement("div");
        header_report_block.className = "report-block-header";
        header_report_block.innerHTML = "Сообщить об ошибке";
        
        let content_report_block = document.createElement("div");
        content_report_block.className = "report-block-content";
        content_report_block.innerHTML = "Пожалуйста, опишите ошибку максимально точно, где и как она проявляется: <div class=\"report-block-form\"><textarea id=\"feedback_error_descr\" class=\"report-textarea\" placeholder=\"Описание ошибки: \"></textarea></div><div class=\"report-footer\"><span id=\"report_status\"></span><button class=\"main-button\" onclick=\"feedback.send()\">Отправить</button><button class=\"main-button btn-f\" onclick=\"feedback.showBox('none')\">Закрыть</button></div>";
        
        report_block.appendChild(header_report_block);
        report_block.appendChild(content_report_block);
        
        ajax_block.appendChild(report_block);
    },
    send: function() {
        let feedback_error_descr = ge("feedback_error_descr").value;
        
        if (feedback_error_descr.length == 0) {
            ge("feedback_error_descr").focus();
            return;
        }
        
        let url = "/?act=feedback&message=" + feedback_error_descr;
        loading("start");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                if (data == 0) {
                    feedback.showBox("none");
                    confirmBox.info("Спасибо Вам, что помогаете нам стать лучше!");
                }
            }
        });
    }
}

var report = {
    type: "",
    display: function(display, id) {
        let ajax_block = ge("ajax_load_block");
        ajax_block.innerHTML = "";
        ajax_block.style.display = display;
        
        let report_block = document.createElement("div");
        report_block.className = "report-block";
        
        let header_report_block = document.createElement("div");
        header_report_block.className = "report-block-header";
        header_report_block.innerHTML = "Сообщить о нарушении";
        
        let content_report_block = document.createElement("div");
        content_report_block.className = "report-block-content";
        content_report_block.innerHTML = "Пожалуйста, выберите причину, по которой Вы хотите сообщить администрации сайта о нарушении: <div class=\"report-block-form\"><select class=\"report-select\" id=\"report_theme\"><option value=\"0\">Выбирите причину</option><option value=\"1\">Порнография</option><option value=\"2\">Оскорбительное содержание</option><option value=\"3\">Спам</option><option value=\"4\">Другая причина</option></select><textarea id=\"descr_report\" class=\"report-textarea\" placeholder=\"Ваш комментарий: \"></textarea></div><div class=\"report-footer\"><span id=\"report_status\"></span><button class=\"main-button\" onclick=\"report.send(" + id + ")\">Отправить</button><button class=\"main-button btn-f\" onclick=\"report.hide()\">Закрыть</button></div>";
        
        report_block.appendChild(header_report_block);
        report_block.appendChild(content_report_block);
        
        ajax_block.appendChild(report_block);
    },
    show: function(id, type) {
        this.type = type;
        this.display("block", id);
    },
    hide: function() {
        this.display("none", 0);
    },
    send: function(id) {
        let report_theme = ge("report_theme").value;
        let report_comment = ge("descr_report").value;
        
        if (report_theme == 0) {
            ge("report_status").innerHTML = "Выбирите причину";
            return;
        }
        
        this.hide();
        
        let url = "/?act=report&type=" + this.type + "&rid=" + id + "&theme=" + report_theme + "&comment=" + report_comment;
        loading("start");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                if (data == 0) {
                    confirmBox.info("Спасибо, Ваша жалоба принята. Наши модераторы рассмотрят ее в ближайшее время.");
                }
            }
        });
    }
}

var comment = {
    s: function(id) {      
        let url = "/?act=comment&post_id=" + id;
        let ajax_load = ge("ajax_load_block");
        
        loading("start");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                scroll(true);
                ajax_load.style.display = "block";
                ajax_load.innerHTML = data;
            }
        });
    },
    close: function() {
        let ajax_load = ge("ajax_load_block");
        ajax_load.style.display = "none";
        ajax_load.innerHTML = "";
        scroll();
    }
}

window.onload = function() {
  var ajax_block = ge("ajax_load_block");
  if (ajax_block == null) return;
  
  ajax_block.onscroll = function() {
    var scroll = ajax_block.pageYOffset || ajax_block.scrollTop;
    var comment_header = ge("comment_header");
        
    if (comment_header == null) return;
    
    if (scroll > 80) { 
        comment_header.classList.add("comment-header-fixed");
    } else {      
        comment_header.classList.remove("comment-header-fixed");
    }
  }
}

var friends = {
    new: function(uid, btn) {
        var btn_friends = ge(btn);
        btn_friends.disabled = true;
        btn_friends.innerHTML = "Обработка"
        
        var url = "/index.php?act=friends&uid=" + uid + "&request=0";
        console.log("Request on add friends started")
        ajax.a(url, {
            callback: function(data) {
                if (data == 0) {
                    btn_friends.innerHTML = "Добавлен в список";
                    console.log("Request on add friends done!");
                    confirmBox.info("Пользователь добавлен в Ваши подписки.");
                } else {
                    btn_friends.innerHTML = "Произошла ошибка."
                    console.error("Request on add friends failed.");
                }
            }
        });
    },
    del: function(uid, btn) {
        var btn_friends = ge(btn);
        btn_friends.disabled = true;
        btn_friends.innerHTML = "Обработка";
        
        var url = "/index.php?act=friends&uid=" + uid + "&request=1";
        console.log("Request on delete friends started")
        ajax.a(url, {
            callback: function(data) {
                if (data == 0) {
                    btn_friends.innerHTML = "Удален из списка";
                    console.log("Request on delete friends done!");
                } else {
                    btn_friends.innerHTML = "Произошла ошибка."
                    console.error("Request on delete friends failed.");
                }
            }
        });
    }
}

var subscription = {
    openPanel: function(id) {
        var panel_user = ge("panel_user_" + id);
        var panel = ge("panel_" + id);
        var spl = ge("spl_" + id);
        
        panel_user.style.height = 0 + "px";
        panel.style.height = 170 + "px";
        spl.setAttribute("onclick", "subscription.closePanel(" + id +")");
    },
    closePanel: function(id) {
        var panel_user = ge("panel_user_" + id);
        var panel = ge("panel_" + id);
        var spl = ge("spl_" + id);
        
        panel_user.style.height = 170 + "px";
        panel.style.height = 0 + "px";
        spl.setAttribute("onclick", "subscription.openPanel(" + id +")");
    },
    del: function(id) {
        var btn_friends = ge("btn_del_" + id);
        btn_friends.disabled = true;
        btn_friends.innerHTML = "Обработка";
        
        var subscription_main = ge("subscription_main_" + id);
        
        var url = "/index.php?act=friends&uid=" + id + "&request=1";
        console.log("Request on delete friends started")
        ajax.a(url, {
            callback: function(data) {
                if (data == 0) {
                    btn_friends.innerHTML = "Удален";
                    console.log("Request on delete friends done!");
                    subscription_main.style.opacity = "0.5";
                } else {
                    confirmBox.info("Ошибка, пожалуйста, повторите попытку позже.");
                    btn_friends.innerHTML = "Произошла ошибка."
                    console.error("Request on delete friends failed.");
                }
            }
        });
    },
    block: function(id) {
        var btn_block = ge("btn_block_" + id);
        btn_block.disabled = true;
        btn_block.innerHTML = "Обработка";
        
        var subscription_main = ge("subscription_main_" + id);
        var btn_del_ = ge("btn_del_" + id);
        
        var url = "/index.php?act=blocking&uid=" + id;
        console.log("Request on delete friends started");
        ajax.a(url, {
            callback: function(data) {
                if (data == 0) {
                    btn_block.innerHTML = "Заблокирован";
                    console.log("User blocking done");
                    subscription_main.style.opacity = "0.5";
                    btn_del_.innerHTML = "Удален из списка";
                    btn_del_.disabled = true;
                } else {
                    confirmBox.info("Ошибка, пожалуйста, повторите попытку позже.");
                    btn_block.innerHTML = "Произошла ошибка";
                    console.error("Request blocking failed");
                }
            }
        });
    },
    release: function(id) {
        var btn_block = ge("release_btn");
        btn_block.disabled = true;
        btn_block.innerHTML = "Обработка";
        
        var url = "/index.php?act=release&uid=" + id;
        console.log("Request on release user started");
        ajax.a(url, {
            callback: function(data) {
                if (data == 0) {
                    btn_block.innerHTML = "Разблокирован";
                    console.log("User release done");
                } else {
                    confirmBox.info("Ошибка, пожалуйста, повторите попытку позже.");
                    btn_block.innerHTML = "Произошла ошибка";
                    console.error("Request blocking failed");
                }
            }
        });
    }
}

var preview = {
    loadImage: function(image_id) {
        loading("start");
        var url = "/?act=preview&p=loadImage&image_id=" + image_id;
        var ajax_load = ge("ajax_load_block");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                if (data == 1) {
                    confirmBox.info("Ошибка при загрузки фотографии. Повторите попытку позже.");
                    return;
                }
                scroll(true);
                ajax_load.style.display = "block";
                ajax_load.innerHTML = data;
            }
        });
    },
    close: function() {
        var ajax_load = ge("ajax_load_block");
        scroll();
        ajax_load.style.display = "none";
        ajax_load.innerHTML = "";
    }
}

function scroll(t = false, x = false) {
    if (t) {
        document.body.style.overflow = "hidden";
        if (x) {
          ge("ajax_load_block").style.overflow = "auto";
        } else {
          ge("ajax_load_block").style.overflowY = "scroll";
        }
    } else {
        document.body.style.overflowY = "scroll";
        ge("ajax_load_block").style.overflow = "hidden";
    }
}

function createCss(t) {
	 var css = document.createElement('link');
	 css.rel = "stylesheet";
	 css.media = "screen";
	 css.href = "/tpl/css/" + t + ".css?12123";
	 document.head.appendChild(css);
}
function createJS(js) {
	 var script = document.createElement('script');
	 script.src = "/tpl/js/" + js;
	 document.head.appendChild(script);
}

//localStorage.setItem("intro_show", "intro");
function Intro() {
  var intro_show = localStorage.getItem("intro_show");
  if (intro_show == "intro") {
    var url = "/?act=intro";
    ajax.a(url, {
      callback: function(data) {
        var ajax_block = ge("ajax_load_block");
        ajax_block.innerHTML = data;
        scroll(true);
        ajax_block.style.display = "block";
        createJS("intro.js?v=17");
      } 
    });
  }
}
/*
class adBlock {
    constructor() {
        window.onload = function() {
            //document.querySelector(".plad").style.display = "block";
        }
    }
}
if (!('adblock' in window)) (new adBlock());
*/

var access = {
    a: function(type) {
        var ajax_block = ge("ajax_load_block");
        var url = "/?act=access&type=" + type;
        
        loading("start");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                ajax_block.innerHTML = data;
                ajax_block.style.display = "block";
            }
        });
    },
    s: function() {
        var pass = ge("password").value;
        
        if (pass.length == 0) {
            ge("password").focus();
            return;
        }
        
        loading("start");
        ajax.post({
            url: "/?act=access",
            data: "password=" + encodeURIComponent(pass),
            callback: function(data) {
                loading("stop");
                if (data == 1) {
                    confirmBox.info("Вы ввели неверный пароль. Повторите попытку еще раз.");
                } else if (data == 0) {
                    confirmBox.info("Ваш аккаунт отключен. Нам очень жаль, что Вы решили покинуть нас. Мы будем ждать Вас снова!");
                } else {
                    var ajax_block = ge("ajax_load_block");
                    ajax_block.style.display = "block";
                    ajax_block.innerHTML = data;
                }
            }
        });
    },
    passwordUpdate: function() {
        var password_value = ge("password").value;
        var password = ge("password");
        
        if (password_value.length == 0 || password_value.length < 6) {
            password.focus();
            return;
        }
        
        loading("start");
        ajax.post({
            url: "/?act=updatePassword",
            data: "password=" + encodeURIComponent(password_value),
            callback: function(data) {
                alert(data);
                loading("stop");
                if (data == 0) {
                    confirmBox.info("Пароль успешно изменен. При следующей авторизации используйте новый пароль.");
                } else {
                    confirmBox.init(CONFIRM_ALERT_ERROR);
                }
            }
        });
    },
    emailUpdate: function() {
        var email_value = ge("email").value;
        var email = ge("email");
        
        if (email_value.length == 0) {
            email.focus();
            return;
        }
        
        var url = "/?act=updateEmail&new_email=" + email_value;
        loading("start");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                if (data == 0) {
                    confirmBox.info("Email адрес был успешно изменен.");
                } else if (data == 1) {
                    confirmBox.info("Произошла ошибка. Повторите попытку позже.");
                } else {
                    confirmBox.info("Данный email адрес уже занят.");
                }
            }
        });
    }, 
    nameUpdate: function() {
        var fname_value = ge("new_f_name").value;
        var fname = ge("new_f_name");
        var lname_value = ge("new_l_name").value;
        var lname = ge("new_l_name");
        
        if (fname_value.length == 0) {
            fname.focus();
        } else if (lname_value.length == 0) {
            lname.focus();
        } else {
            var url = "/?act=updateName&fname=" + fname_value + "&lname=" + lname_value;
            loading("start");
            ajax.a(url, {
                callback: function(data) {
                    loading("stop");
                    console.log(data);
                    if (data == 0) {
                        confirmBox.info("Имя успешно изменено.");
                    } else {
                        confirmBox.info("Произошла ошибка. Повторите попытку позже.");
                    }
                }
            });
        }
    },
    close: function() {
        var ajax_block = ge("ajax_load_block");
        ajax_block.style.display = "none";
        ajax_block.innerHTML = "";
    }
}

var settings = {
    gi: function(category, v = "") {
        var ajax_block = ge("ajax_load_block");
        
        switch (category) {
            case 0:
                access.a(category);
                break;
                
            case 1:
                var url = "/?act=access&nameUpdate=true";
                loading("start");
                ajax.a(url, {
                    callback: function(data) {
                        loading("stop");
                        ajax_block.style.display = "block";
                        ajax_block.innerHTML = data;
                    }
                });
                break; 
                
            case 2:
                var url = "/?act=access&emailUpdate=true";
                loading("start");
                ajax.a(url, {
                    callback: function(data) {
                        loading("stop");
                        ajax_block.style.display = "block";
                        ajax_block.innerHTML = data;
                    }
                });
                break;
                
            case 3:
                access.a(category);
                break;
                
            case 4:
                if (v == 0) {
                    v = "standart";
                }
                localStorage.setItem("ThemeSite", v);
                siteTheme();
                break;
            
            case 5:
                localStorage.setItem("intro_show", "intro");
                Intro();
                break;
            
            default:
                break;
        }  
    } 
}

var bigInfo = {
  close: function() {
    ge("big_info").classList.add("none");
    localStorage.setItem("big_info", "show");
  }
}

function onloadPage() {
  Intro();
  hashUrl();
  siteTheme();
}

function siteTheme() {
    var theme = localStorage.getItem("ThemeSite") ? localStorage.getItem("ThemeSite") : "standart";
    console.log(theme);
    if (theme == "dark") {
        createCss("darkTheme");
    } else if (theme == "standart") {
        createCss("main");
    } else if (theme == "gold") {
        createCss("gold");
    }
}

var search = {
  e: function(event, value) {
      var e = event || window.event;
      if (e.keyCode == 13) {
        if (value.length == 0 || value.length < 3) {
          ge("search_input").focus();
        } else {
          this.q(value);
        }
      }
  },
  q: function(v) {
      var search_block_res = ge("search_result_block");
      var search_processing = ge("search_processing");
      
      search_processing.innerHTML = "Выполняю поиск";
      
      var url = "/?act=search&q=" + encodeURIComponent(v);
      ajax.a(url, {
          callback: function(data) {
             search_processing.innerHTML = "Поиск";
             search_block_res.style.padding = "0px 20px";
             search_block_res.innerHTML = data;

             var search_hash = "#s=" + encodeURIComponent(v);
             document.location.hash = search_hash;
          }
      }); 
  },
  req: function(event, v) {
      var e = event || window.event; 
      if (v.length == 0 || v.length < 3) {
        ge("search_result_block").innerHTML = "Запрос должен быть не меньше 3 символов.";
      } else {
        if (e.keyCode == 13) return;
        ge("search_result_block").innerHTML = "Здесь Вы увидите результат поиска.";
      } 
  },
  req_: function(event, v) {
      var e = event || window.event;
      if (e.keyCode == 13) {
        if (v.length == 0 || v.length < 3) {
          ge("inp_search").focus();
          return;
        }
        var s_hash = "#s=" + encodeURIComponent(v);
        ajax.page("/search" + s_hash, hashUrl);
      } 
  }
}

function hashUrl() {
    var hash = document.location.hash;
    var param_hash = hash.split("=")[0];
    var value_hash = hash.split("=")[1];
    
    switch (param_hash) {
        case "#s":
            var search_input = ge("search_input");
            search_input.value = decodeURIComponent(value_hash);
            search.q(decodeURIComponent(value_hash));
          break;
    }
}

var timeEmail = setTimeout(function(){
   var url = "/status.php?act=email_ver";
   var intro_ = localStorage.getItem("intro_show");
   if (intro_ == "intro") {
       clearTimeout(timeEmail);
       return;
   }
   
   ajax.a(url, {
       callback: function(data) {
           if (data == 0) {
               clearTimeout(timeEmail);
               return;
           }
           var ajax_block = ge("ajax_load_block");
           
           if (ajax_block == null) return;
           
           ajax_block.innerHTML = data;
           scroll(true);
           ajax_block.style.display = "block";
           clearTimeout(timeEmail);
       }
   });
}, 1000);

var emailVer = {
    send: function() {
        var pathName = document.location.pathname;
        if (pathName == "/registration_info") return;
        
        var url = "/status.php?act=sendEmailVer";
        ajax.a(url, {
            callback: function(data) {
                if (data == 0) {
                    ge("btn_send_email_v").disabled = true;
                    ge("btn_send_email_v").innerHTML = "Письмо отправлено";
                } else {
                    console.error("Error send email" + data);
                }
            }
        });
    }
}

var competition = {
    oldResult: function() {
        var url = "/?act=competitionOldResult";
        scroll(true, true);
        loading("start");
        ajax.a(url, {
            callback: function(data) {
                loading("stop");
                if (data == -1) {
                    confirmBox.info("Прошлый результат не доступен по причине отсутствия участников или конкурс не был заявлен.");
                } else {
                    var ajax_block = ge("ajax_load_block");
                    ajax_block.innerHTML = data;
                    ajax_block.style.display = "block";
                }
            }
        });
    },
    closeOldResult: function() {
        scroll();
        var ajax_block = ge("ajax_load_block");
        ajax_block.innerHTML = "";
        ajax_block.style.display = "none";
    }
}

var fb = {
    loadPhotoNew: function() {
        var btn_fix = ge("fb_btn_fixed");
        btn_fix.classList.add("fb-btn-fixed-trans");
        
        scroll("true");
        
        var container_mobile = ge("container_mobile");
        container_mobile.classList.add("load-photo-container-mobile-h");
    },
    selectPhoto: function() {
        ge("photo").click();
    },
    uploadPhoto: function() {
        var preview_text  = ge("preview_text_mobile").value;
        var preview_title = ge("preview_title_mobile").value;
        var preview_category = ge("preview_category_mobile");
        var category;
        var processing_text = ge("upload_result");
        var input = ge("photo");
        
        if (!input.files[0]) {
            ge("photo").click();
            return;
        }
        
        if (preview_category.value == 0) {
            ge("preview_category_mobile").focus();
            return;
        }
        
        category = preview_category.value;
        
        var url = "/index.php?act=album&p=updateInfo&text=" + preview_text + "&title=" + preview_title + "&category=" + category;
        
        processing_text.innerHTML = "Загрузка ... ";
        ajax.a(url, {
            callback: function(data) {
                if (data == 1) {
                    processing_text.innerHTML = "Фотография успешно загружена";
                } else {
                    console.error("[Error] Name error: UPLOAD ERROR.");
                    console.error("[Description] Description error: " + data);
                }
            }
        });
    },
    clear: function() {
        var btn_fix = ge("fb_btn_fixed");
        btn_fix.classList.remove("fb-btn-fixed-trans");
        
        scroll();
        
        var container_mobile = ge("container_mobile");
        container_mobile.classList.remove("load-photo-container-mobile-h");
    }
}

var store = {
    h: function() {
        return ajax.page("/store");
    },
    cntRating: function(v) {
        if (+v > 1000000) {
            confirmBox.info("Вы можете купить максимум 1 000 000 рейтинга.");
        }
        var summ = +v * 0.22;
        var storeBtnRating = ge("store_btn_cnt_rating");
        storeBtnRating.innerHTML = "купить за " + summ + " руб."; 
    },
    buyGoods: function(n) {
       var url = "/?act=store&s=buy&p=" + n;
       loading("start");
       ajax.a(url, {
           callback: function(data) {
               loading("stop");
               if (data == 0) {
                   confirmBox.info("Спасибо за пакупку! Начисление произойдет в ближайшее время.");
               } else if (data == 1) {
                   confirmBox.info("К сожалению, у Вас недостаточно репутации, чтобы оплатить данный товар.");
               } else {
                  confirmBox.info("Произошла ошибка. Повторите, пожалуйста, через несколько минут."); 
               }
           }
       });
    }
}

function coverProfileCSS(bool_ = false) {
    if (!bool_) {
      var path = document.location.pathname.split("/")[1];
      if (!/ID[0-9]{1,}/i.test(path)) return;
    }
    
    if (!(screen.width <= 640)) return;
    
    var profile_cover = document.querySelector(".profile-cover-img");
    if (profile_cover != null) {
        var header_content_ = document.querySelectorAll(".header-content")[0];
        header_content_.classList.add("header-content-mobile-cover");
        
        var header_logo = document.querySelector(".header-logo");
        if (header_logo != null) {
          header_logo.style.display = "none";
        }
        
        var main_content = document.querySelectorAll(".main-content-page")[0];
        main_content.classList.add("cover-mobile-main-content");
    }
}
/*
window.onscroll = function() {
  var scroll = window.pageYOffset || window.scrollTop;
  var profile_cover = document.querySelector(".profile-cover-img");
  var header_content_ = document.querySelectorAll(".header-content")[0];
  
  var path = document.location.pathname.split("/")[1];
  if (screen.width <= 640 && profile_cover != null && /ID[0-9]{1,}/i.test(path)) {
      var main_content = document.querySelectorAll(".main-content-page")[0];
      main_content.classList.add("cover-mobile-main-content");
      if (scroll >= 0 && scroll < 200) {
        var opacity_ = scroll / 100;
        if (opacity_ >= 1) {
            opacity_ = 1;
        }
        header_content_.style.opacity = opacity_; 
      }
  }
}
*/
var message_ = {
    createFrom: function(text) {
        var message_container = ge("room_message_container");
        var message_block = document.createElement("div");
        var message = document.createElement("div");
        message.classList.add("message-from-user");
        message.classList.add("flr");
        message.innerHTML = text;
        var block_clear = document.createElement("div");
        block_clear.classList.add("clear");
        message_block.appendChild(message);
        message_block.appendChild(block_clear);
        message_container.appendChild(message_block);
    },
    createTo: function(text, effect = "") {
        var message_container = ge("room_message_container");
        var message_block = document.createElement("div");
        var message = document.createElement("div");
        message.classList.add("message-to-user");
        message.classList.add("fll");
        if (effect != "") {
          message.classList.add(effect);
        }
        message.innerHTML = text;
        var block_clear = document.createElement("div");
        block_clear.classList.add("clear");
        message_block.appendChild(message);
        message_block.appendChild(block_clear);
        message_container.appendChild(message_block);
    },
}
var room = {
    _MSG: false,
    category: {
        none: function() {
          confirmBox.info("Нет нужной категории? Теперь это не проблема. <br/>Напишите на <b>support@web-nucleus.com</b> с <br/> темой \"Новая категория для общения\" и мы рассмотрим Вашу заявку.");  
        },
        start: function() {
          ajax.page("/room/start");  
        },
    },
    message: {
        send: function() {
          var msg_textarea = ge("msg_textarea").value;
          if (msg_textarea.length == 0) {
              ge("msg_textarea").focus();
              return;
          }
          
          ge("room_message_container").scrollTop = ge("room_message_container").scrollHeight;
        },
        sendTest: function() {
          var msg_textarea = ge("msg_textarea").value;
          if (msg_textarea.length == 0) {
              ge("msg_textarea").focus();
              return;
          }
          message_.createFrom(msg_textarea); 
          
          if (msg_textarea.toLowerCase() == "да" && room._MSG) {
            message_.createTo("Замечательно!", "boom-effect");
            room._MSG = false;
            setTimeout(function() {
              message_.createTo("Для начала мы предлагаем ознакомиться с <a href=\"/terms\">правилами общения</a>.");
              message_.createTo("Общение между пользователями анонимное. Но! Если Вы захотите раскрыть свое имя, то Вашему собеседнику придется тоже его раскрыть. ");
              ge("room_message_container").scrollTop = ge("room_message_container").scrollHeight;
              setTimeout(function() {
                  message_.createTo("В зависимости от общения с собеседником, Вам будут начисляться баллы к репутации, которые откроют новые эффекты отправки сообщений.");
                  message_.createTo("В конце знакомства, если Вы проходите его первый раз, то получите +5 баллов к рейтингу.");
                  message_.createTo("<a href=\"#\" onclick=\"room.message.endTest()\">Закончить обучение</a>");
                  ge("room_message_container").scrollTop = ge("room_message_container").scrollHeight;
              }, 3000);
            }, 1000);
          }
          
          ge("msg_textarea").value = "";
          ge("room_message_container").scrollTop = ge("room_message_container").scrollHeight;
        },
        startTest: function() {
          var btn_start = ge("room_btn_start_example");
          btn_start.classList.add("none");
          
          var btn_send_test = ge("btn_send_test");
          btn_send_test.setAttribute("onclick", "room.message.sendTest()");
          var btn_send_test_mob = ge("btn_send_test_mobile");
          btn_send_test_mob.setAttribute("onclick", "room.message.sendTest()");
          
          message_.createTo("Добро пожаловать в мир общения!"); 
          message_.createTo("Готовы? Отправте да, если готовы.");
          ge("msg_textarea").value = "Да";
          room._MSG = true; 
        },
        endTest: function() {
          message_.createFrom("Закончить обучение"); 
          ge("room_message_container").scrollTop = ge("room_message_container").scrollHeight;
          
          var url = "/index.php?act=roomStart";
          message_.createTo("Пожалуйста, подождите ..."); 
          ajax.a(url, {
              callback: function (data) {
                if (data == 0) {
                  message_.createTo("Еще секундочку:)"); 
                  var url_ = "/index.php?act=roomLessonEnd";
                  ajax.a(url_, {
                      callback: function(data_) {
                        console.log("Lesson data - " + data_);
                        if (data_ == 0) {
                          message_.createTo("Спасибо! Вам начислено 5 баллов к репутации."); 
                        } else {
                          message_.createTo("Упс.. Ошибка."); 
                        }
                        ge("room_message_container").scrollTop = ge("room_message_container").scrollHeight;
                      }
                  });
                } else {
                  message_.createTo("Спасибо!"); 
                }
                ge("room_message_container").scrollTop = ge("room_message_container").scrollHeight;
              }
          });
        }
    },
}

var promocode = {};
promocode.onKeyDownActivate = function(e) {
    var e = event || window.event;
    var target = e.target;
    var id_ = target.id;
    var el  = document.getElementById(id_);
    var value_len = (el.value).length;
    if (value_len >= 18) {
        el.value = (el.value).substring(0, 18);
        return false;
    } else {
        var key_code = e.keyCode;
        if ((value_len == 4 || value_len == 9 || value_len == 14) && key_code != 8) {
            el.value = el.value + "-";
        }
    }
}
promocode.activateBonus = function() {
    var el = document.getElementById("promocode_input");
    var el_error = document.getElementById("promocode_error");
    if ((el.value).length == 0) {
      el.focus();
      return;
    } else if ((el.value).length < 19) {
      el_error.innerHTML = "Неверный промокод";
      el_error.classList.add("promocode-error");
      el.focus();
      return;
    }
    var url = "/?act=promocode&code=" + el.value;
    loading("start");
    ajax.a(url, {
        callback: function(data) {
            console.log("Result activate promocode - " + data);
            if (data == 1) {
              el_error.innerHTML = "Неверный промокод";
              el_error.classList.add("promocode-error");
            } else if (data == 2) {
              el_error.innerHTML = "Промокод уже недействителен.";
              el_error.classList.add("promocode-error");
            } else {
              var el_side_back = document.querySelector(".promocode_coupon_side--back");
              var el_side_font = document.querySelector(".promocode_coupon_side--font");
              el_side_back.classList.remove("promocode_coupon_side--back");
              el_side_font.classList.add("promocode_coupon_side--back");
            }
            loading();
        }
    });
}

var fxMobileMenu = {};
fxMobileMenu.fx_default = "fx_home";
fxMobileMenu.e = function(id) {
    if (id != fxMobileMenu.fx_default) {
        ge(fxMobileMenu.fx_default).style.opacity = "0.8";
        fxMobileMenu.fx_default = id;
        ge(id).style.opacity = "1";
    }
}