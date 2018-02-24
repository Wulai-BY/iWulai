/* author:iWulai */
(function(){
    var iWulai = function () { return this };
    iWulai.typeof = function ( variable ) {
        variable = Object.prototype.toString.call( variable );
        var _return;
        switch ( variable ) {
            case '[object String]' :
                _return = 'string';
                break;
            case '[object Number]' :
                _return = 'number';
                break;
            case '[object Boolean]' :
                _return = 'boolean';
                break;
            case '[object Undefined]' :
                _return = 'undefined';
                break;
            case '[object Null]' :
                _return = 'null';
                break;
            case '[object Object]' :
                _return = 'object';
                break;
            case '[object Array]' :
                _return = 'array';
                break;
            case '[object Function]' :
                _return = 'function';
                break;
        }
        return _return;
    };
    iWulai.autoAlert = function ( string, status, callback ) {
        var container = document.getElementById( 'iWulai-auto-alert' ),
            elem = document.createElement( 'p' );
        if ( !container ) {
            container = document.createElement( 'div' );
            container.id = 'iWulai-auto-alert';
            document.body.insertAdjacentElement( 'afterbegin', container );
        }
        if ( iWulai.typeof( status ) === 'function' ) {
            callback = status;
            status = false;
        } else {
            status = !!status;
        }
        var statusClassName = status ? 'success' : 'error';
        elem.innerHTML = string;
        elem.className = statusClassName + ' slideDown';
        elem.addEventListener( 'webkitAnimationEnd', function () {
            setTimeout( function () {
                elem.className = statusClassName + ' slideUp';
                elem.removeEventListener( 'webkitAnimationEnd', function () {} );
                elem.addEventListener( 'webkitAnimationEnd', function () {
                    elem.parentNode.removeChild( elem );
                    if ( container.getElementsByTagName( 'p' ).length === 0 ) {
                        container.parentNode.removeChild( container );
                        if ( iWulai.typeof( callback ) === 'function' && callback.call( this ) === false ) return false;
                    }
                } );
            }, 1800 );
        } );
        container.insertAdjacentElement( 'afterbegin', elem );
    };
    iWulai.uploadPicture = function ( that ) {
        var files = that.files,
            id = 1,
            url = that.getAttribute( 'data-url' ),
            formdata = new FormData();
        if ( files.length === 0 ) return false;
        for ( var i in files ) {
            if ( files.hasOwnProperty( i ) ) {
                var file = files[ i ],
                    checkPicRes = checkPicture( file );
                if ( checkPicRes.status ) {
                    createPicture( file );
                    formdata.append( 'img_' + id, file );
                    id++;
                }
                else {
                    iWulai.autoAlert( file.name + '：' + checkPicRes.info );
                }
            }
        }
        var xhr = new XMLHttpRequest();
        xhr.open( 'POST', url, true );
        xhr.setRequestHeader( 'Accept', 'application/json' );
        xhr.setRequestHeader( 'Cache-Control', 'no-cache' );
        xhr.onreadystatechange = function () {
            if ( xhr.readyState === 4 && ( xhr.status === 200 || xhr.status === 304 ) ) {
                console.log(JSON.parse(xhr.responseText));
            }
            else {

            }
        };
        xhr.send(formdata);
    };
    function checkPicture ( file ) {
        var res = { 'status' : false, 'info' : '' };
        var arr = [ 'image/jpeg', 'image/png', 'image/gif' ];
        if ( arr.indexOf.call( arr, file.type ) === -1 ) {
            res.info = '图片类型限制！'
        }
        else if ( file.size > 2*1024*1024 ) {
            res.info = '图片大小超出限制！'
        }
        else {
            res.status = true;
        }
        return res;
    }
    function createPicture ( file ) {
        var reader = new FileReader();
        var img = document.createElement( 'img' );
        reader.onload = function ( event ) {
            img.src = event.target.result;
            img.title = file.name;
            img.alt = file.name;
            document.getElementById( 'iWulai-view' ).insertAdjacentElement( 'beforeend', img );
        };
        reader.readAsDataURL( file );
    }
    window.iWulai = iWulai;
    return iWulai;
})();