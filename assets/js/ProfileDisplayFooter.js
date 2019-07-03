import React from "react";
import ReactDOM from "react-dom";
require('bootstrap');

export default class ProfileDisplayFooter extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            loading: true
        };
    }

    componentDidMount() {
        this._isMounted = true;
        this.setFooterInfo(this.props.footer);
    }

    componentWillReceiveProps(nextProps) {
        this._isMounted = true;
        this.setFooterInfo(nextProps.footer);
    }

    setFooterInfo(footer) {
        if (this._isMounted)
            this.setState({footer: footer});
    }

    componentWillUnmount() {
        this._isMounted = false;
    }
    render() {

        return (<div id="footerContainer" className="bg-six op-9 vdark container-fluid">

    <div className="row">
    <div id="footerContents"><span className="footer-item px-2">Created with <a href="https://github.com/mycwnet/resume" className="footer-link px-1">simple resume app</a></span></div>
    </div>
</div>

                );
    }
}

