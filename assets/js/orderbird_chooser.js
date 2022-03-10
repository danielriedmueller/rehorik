(() => {
    const ids = ['cafe-190-grad', 'rehorik-rosterei-kaffehaus'];
    const dropdown = document.getElementById('orderbird-chooser-dropdown');
    const widgetContainer = document.getElementById('resmio-' + ids[0]);
    const head = document.getElementsByTagName('head')[0];
    const updateWidget = (id) => {
        widgetContainer.setAttribute('id', 'resmio-' + id);
        widgetContainer.innerHTML = '';
        if (this.widget) {
            this.widget.remove();
        }
        this.widget = document.createElement("script");
        this.widget.src = "//static.resmio.com/static/de/widget.js#id=" + id;
        head.appendChild(this.widget);
    }

    updateWidget(ids[0]);
    dropdown.onchange = (e) => {
        const id = e.target.value;
        if (!ids.includes(id)) {
            throw 'Wrong location id.' + id + ' does not exist.'
        }
        updateWidget(id);
    }
})();