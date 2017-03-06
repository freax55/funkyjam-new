function shortcut() {
    var $window = $(window);
    var $this = $("#<?= Inflector::camelize($this->params['controller'])?>Q");
    var sc1 = 47; /* Focus on search with a slash */

    $window.on('keypress', function(event) {
        // console.log(event.keyCode);
        switch(event.keyCode) {
            case sc1:
                $this.focus();
                $this.val("");
                return false;
                break;
        };
    });
}
shortcut();
