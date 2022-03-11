(() => {
    const head = document.getElementsByTagName('head')[0];
    const widgetContainer = document.getElementById('resmio');
    const radios = document.getElementsByName('orderbird-radio');
    let activeId;

    radios.forEach((radio) => {
        const id = radio.value;
        if (radio.checked) activeId = id;
        radio.onchange = () => updateWidget(id);
    })

    const updateWidget = (id) => {
        widgetContainer.setAttribute('id', 'resmio-' + id);
        widgetContainer.innerHTML = '';
        if (this.widget) this.widget.remove();
        this.widget = document.createElement("script");
        this.widget.src = "//static.resmio.com/static/de/widget.js#id=" + id + "&color=%23ceb67f&width=275&height=400&fontSize=14px&facebookLogin=false&backgroundColor=%235c0d2f&commentsDisabled=true&newsletterSignup=false&linkBackgroundColor=%23ceb67f"
        head.appendChild(this.widget);
    }

    if (activeId) updateWidget(activeId);
})();