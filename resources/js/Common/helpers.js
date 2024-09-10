export default {
    getImageUrl: function (path) {
        return new URL(path, import.meta.url).href
    },

    prettyObject: function (object) {
        return JSON.stringify(object, 0, 2)
    }
}
