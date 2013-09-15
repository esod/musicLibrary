        function createPlayer() {
            var flashvars = {
                    file:"video.flv", 
                    autostart:"true"
            }
            var params = {
                    allowfullscreen:"true", 
                    allowscriptaccess:"always"
            }
            var attributes = {
                    id:"player1",  
                    name:"player1"
            }
            swfobject.embedSWF("player.swf", "placeholder1", "320", "196", "9.0.115", false, flashvars, params, attributes);
        }