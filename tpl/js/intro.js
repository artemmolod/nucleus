var pos = 0;

var view = {
    active_control: "control0",
    init: function() {
        ge(this.active_control).classList.add("control-active");
    },
    Next: function(i) {
        var control = "control" + i;
        ge(this.active_control).classList.remove("control-active");
        this.active_control = control;
        this.init();
        pos = i;
        
        var container = document.querySelector(".intro-step-container");
        container.style.left = (-i * 740) + "px";
    },
    delLocalKey: function() {
        localStorage.removeItem("intro_show");
        ge("ajax_load_block").style.display = "none";
        scroll(false);
    }
}
view.Next(0);

document.onkeydown = function(event) {
    var e = event || window.event;
    if (e.keyCode == 39) {
        if (pos >= 7) pos = 7;
        else ++pos;
        view.Next(pos);
    }
    if (e.keyCode == 37) {
        if (pos <= 0) pos = 0;
        else --pos;
        view.Next(pos);
    }
}