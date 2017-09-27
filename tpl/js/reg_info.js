var reg_info = {
    stepOne: function() {
        var fname = ge("first_name").value;
        var lname = ge("last_name").value;
        var bdate = ge("bdate").value;
        var sex   = ge("sex").value;
        var btn   = ge("btn_reg_info");
        var stat_ = ge("reg_name");
        
        if (fname.length == 0) 
            ge("first_name").focus();
        else if (lname.length == 0)
            ge("last_name").focus();
        else if (bdate == "")
            ge("bdate").focus();
        else if (sex == -1) 
            ge("sex").focus();
        else {
            var url = "/registration_info.php?fname=" + fname + "&lname=" + lname + "&bdate=" + bdate + "&sex=" +                               sex;
            btn.disabled = true;
            stat_.innerHTML = "Обработка ...";
            ajax.a(url, {
                callback: function(data) {
                    console.log("Server said: " + data);
                    if (data == "bdateError") {
                        stat_.innerHTML = "Ошибка указания даты.";
                        btn.disabled = false;
                    } else if (data == "done") {
			localStorage.setItem("intro_show", "intro");
                        reg_info.stepNext(2);
                    } else {
                        stat_.innerHTML = "Ошибка данных.";
                        btn.disabled = false;
                    }
                }
            });
        }
    },
    stepTwo: function() {
        ge('photo').click();
    },
    stepNext: function(n) {
        var step1 = ge("step1");
        var step2 = ge("step2");
        var step3 = ge("step3");
        var stat_ = ge("reg_name");
        var title = ge("reg_title");
        var tab   = ge("tab_");
        
        switch (n) {
            case 3:
                stat_.style.display = "none";
                step1.style.display = "none";
                step2.style.display = "none";
                step3.style.display = "block";
                tab.innerHTML       = "Готово";
                break;
            
            case 2:
                stat_.style.display = "none";
                step1.style.display = "none";
                step2.style.display = "block";
                step3.style.display = "none";
                tab.innerHTML       = "Загрузка фотографии";
                break;    
        }
    }
}