// http://stackoverflow.com/a/14853974
Array.prototype.equals = function (array)
{
    if (!array)
    {
        return false;
    }

    if (this.length != array.length)
    {
        return false;
    }

    for (var i = 0, l=this.length; i < l; i++) {
        if (this[i] instanceof Array && array[i] instanceof Array)
        {
            if (!this[i].equals(array[i]))
            {
                return false;
            }
        }
        else if (this[i] != array[i])
        {
            return false;
        }
    }
    return true;
};

Array.prototype.filterEmpty = function ()
{
    return this.filter(function(e){
        if (e instanceof Array)
        {
            e = e.filterEmpty();
            return e.length > 0;
        }
        return e === 0 || e != null
    })
};