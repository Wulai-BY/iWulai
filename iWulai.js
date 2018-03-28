/* +--------------------------------------------------+ */
/* | Author : iWulai <iwulai@qq.com> <www.iwulai.com> | */
/* +--------------------------------------------------+ */
( function () {
    var iWulai = function ( name ) {
        this.name = 'iWulai' || name;
    };
    iWulai.prototype.girlFriend = function () {
        return 'You have no girl friend! Please wake up!';
    };
    window.iWulai = iWulai;
    return iWulai;
} ) () ;
