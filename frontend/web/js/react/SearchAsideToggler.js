// Require
// 'https://unpkg.com/universal-cookie@3/umd/universalCookie.min.js',
// 'https://unpkg.com/react@17/umd/react.production.min.js',
// 'https://unpkg.com/react-dom@17/umd/react-dom.production.min.js',

class SearchAsideToggler extends React.Component {
    cookies = new UniversalCookie();

    constructor(props) {
        super(props);
        this.state = {
            enable: this.cookies.get("filter_toggles") || true,
        }

        this.setEnableState = this.setEnableState.bind(this);
        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(e) {
        this.setEnableState(e.target.value === "on");
    }

    setEnableState(isEnable) {
        this.setState({enable: isEnable});
        this.cookies.set("filter_toggles", isEnable);
    }

    componentDidUpdate() {
        this.state.enable ? this.props.enableEvent() : this.props.disableEvent();
    }

    render() {
        return React.createElement("div", {
                className: "catalog__toggler"
            },
            React.createElement("label", {
                    className: "input__switch"
                },
                React.createElement("input", {
                    type: "checkbox",
                    name: "toggler_side",
                    onClick: this.handleClick,
                    id: "toggler_side"
                }), React.createElement("span", {
                    className: "input__switch-icon"
                }, React.createElement("span", {
                    className: "input__switch-move"
                })))
        );
    }
}

// Events
const changeCatalog = (action) => {
    let catalogNode = document.getElementById("fn_catalog_container");
    if (catalogNode) {
        action(catalogNode);
    }
};
const enableEvent = () => {
    changeCatalog(node => {
        node.classList.add("filter--show");
    });
};
const disableEvent = () => {
    changeCatalog(node => {
        node.classList.remove("filter--show");
    });
};

// Render
const domContainer = document.querySelector('#catalog__toggler');
if (domContainer) {
    ReactDOM.render(React.createElement(SearchAsideToggler, {
        enableEvent,
        disableEvent
    }), domContainer);
}
