import React from "react";
import ReactDOM from "react-dom";
import { Link as RouterLink } from "react-router-dom";

var $ = require('jquery');
require('bootstrap');

export default class ProfileDisplayHeader extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            header: this.props.header
        };
    }

    componentDidMount() {
        this._isMounted = true;
        this.setHeaderInfo(this.props.header);
    }

    componentWillReceiveProps(nextProps) {
        this._isMounted = true;
        this.setHeaderInfo(nextProps.header);
    }

    setHeaderInfo(header) {
        if (this._isMounted)
            this.setState({header: header});
    }

    componentWillUnmount() {
        this._isMounted = false;
    }
    render() {
        return (<div id="headerContainer" className="bg-three op-3 dark container-fluid">
        
            <div className="row">
        
                <nav className="navbar navbar-expand-md w-100 pt-1">
                    <a className="navbar-brand text-three py-0" href="#">
                        <div id="siteLogo" className="d-inline-block my-auto">
                            <img src={"files/images_directory/" + this.state.header.site_logo} className="rounded"/>
                        </div>
                        <h1 id="siteName" className="font-size-1 d-inline-block my-auto">{this.state.header.site_title}</h1>
                    </a>
                    <button className="navbar-toggler bdr-three text-three" type="button" data-toggle="collapse" data-target="#headerLinks">
                        <i className="fa fa-bars fa-2"/>
                    </button>
                    <div id="headerLinks" className="collapse navbar-collapse my-0 mr-0 justify-content-end">
                        <ul id="headerLinksList" className="navbar-nav inline text-right justify-content-end my-0">
                            <li id="skillsLink" className="header-link nav-item d-inline-block px-1">
                            <RouterLink
                                to={{
                                                pathname: "/",
                                                hash: "#loc=skills",
                                                state: {
                                                    pageLoc: "skills"
                                                }
                                            }}
                                className="nav-link d-inline-block text-center text-three px-0"
                                >
                                <div id="skillsIcon" className="header-link-icon py-0">
                                    <i className="fas fa-tools"></i>
                                </div>
                                <div id="skillsText" className="header-link-text font-size-1">Skills</div>
                            </RouterLink>
                            </li>
                            <li id="projectsLink" className="header-link nav-item d-inline-block px-1">
                            <RouterLink
                                to={{
                                                pathname: "/",
                                                hash: "#loc=projects",
                                                state: {
                                                    pageLoc: "projects"
                                                }
                                            }}
                                className="nav-link d-inline-block text-center text-three px-0"
                                >
                                <div id="projectsIcon" className="header-link-icon py-0">
                                    <i className="fas fa-book-open"></i>
                                </div>
                                <div id="projectsText" className="header-link-text font-size-1">Projects</div>
                            </RouterLink>
                            </li>
                            <li id="samplesLink" className="header-link nav-item d-inline-block px-1">
                            <RouterLink
                                to={{
                                                pathname: "/",
                                                hash: "#loc=samples",
                                                state: {
                                                    pageLoc: "samples"
                                                }
                                            }}
                                className="nav-link d-inline-block text-three text-center px-0"
                                >
                                <div id="samplesIcon" className="header-link-icon py-0">
                                    <i className="fas fa-vial"></i>
                                </div>
                                <div id="samplesText" className="header-link-text font-size-1">Samples</div>
                            </RouterLink>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

                );
    }
}