(function () {

    function chunk(collection, size) {

        var result = [];

        // default size to two item
        size = parseInt(size) || 2;

        // add each chunk to the result
        for (var x = 0; x < Math.ceil(collection.length / size); x++) {
            var start = x * size;
            var end = start + size;
            result.push(collection.slice(start, end));
        }
        return result;
    };

    // export in node or browser
    if (typeof exports !== 'undefined') {
        if (typeof module !== 'undefined' && module.exports) {
            exports = module.exports = chunk;
        }
        exports.chunk = chunk;
    } else {
        this.chunk = chunk;
    }

}.call(this));