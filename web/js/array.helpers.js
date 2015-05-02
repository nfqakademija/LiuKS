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
    var arr = this;
    var i = arr.length;
    while (i--)
    {
        if (arr[i] instanceof Array)
        {
            arr[i] = arr[i].filterEmpty();
            if (arr[i].length == 0)
            {
                arr.splice(i, 1);
            }
        }
        else
        if (arr[i] !== 0 && arr[i] == null)
        {
            arr.splice(i, 1);
        }
    }
    return arr;
};