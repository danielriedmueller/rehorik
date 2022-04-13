(() => {
    const orderbirdChooserContainer = document.getElementById('orderbird-chooser');
    const head = document.getElementsByTagName('head')[0];
    const widgetContainer = document.getElementById('resmio');
    const radios = document.getElementsByName('orderbird-radio');
    let activeId;

    radios.forEach((radio) => {
        const id = radio.value;
        if (radio.checked) activeId = id;
        radio.onchange = () => updateWidget(id);
        radio.onclick = () =>  {
            orderbirdChooserContainer.classList.add('active');
            history.pushState({}, "");
        }
    })

    const updateWidget = (id) => {
        widgetContainer.setAttribute('id', 'resmio-' + id);
        widgetContainer.innerHTML = '';
        if (this.widget) this.widget.remove();
        this.widget = document.createElement("script");
        this.widget.src = "//static.resmio.com/static/de/widget.js#id=" + id + "&color=%23393536&width=275&height=400&fontSize=14px&facebookLogin=false&backgroundColor=%23ffffff&commentsDisabled=false&newsletterSignup=false&linkBackgroundColor=%235c0d2f"
        head.appendChild(this.widget);
    }

    window.onpopstate = function(event) {
        orderbirdChooserContainer.classList.remove('active');
    };

    if (activeId) updateWidget(activeId);
})();