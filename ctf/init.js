(function(global, $){
    
    // Define core
    var codiad = global.codiad,
        scripts= document.getElementsByTagName('script'),
        path = scripts[scripts.length-1].src.split('?')[0],
        curpath = path.split('/').slice(0, -1).join('/')+'/';
        

    // Instantiates plugin
    $(function() {    
        codiad.ctf.init();
    });

    codiad.ctf = {
        
        // Allows relative `this.path` linkage
        path: curpath,

        init: function() {
			
        },

	     submit: function() {
	     	var _this = this;
	        $.post(_this.path + 'controller.php', {"action":"submit"} , function(result){
	        	var msg = JSON.parse(result);
	        	codiad.message[msg.status](msg.message);
            });
	     },
	     
	     reset: function() {
	     	var _this = this;
	        $.post(_this.path + 'controller.php', {"action":"reset"}, function(result){
                var msg = JSON.parse(result);
	        	codiad.message[msg.status](msg.message);
            });
	     },
dialog: 'components/ctf/dialog.php',
review: function(){
   var _this = this;
            codiad.modal.load(400, this.dialog);	    
},


    };

})(this, jQuery);
