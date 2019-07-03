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
            header: this.props.header,
            path: this.props.path
        };
    }

    componentDidMount() {
        this._isMounted = true;
        this.setHeaderInfo(this.props.header);
        this.setPathInfo(this.props.path);
    }

    componentWillReceiveProps(nextProps) {
        this._isMounted = true;
        this.setHeaderInfo(nextProps.header);
        this.setPathInfo(nextProps.path);
    }

    setHeaderInfo(header) {
        if (this._isMounted)
            this.setState({header: header});
    }
    setPathInfo(path) {
        if (this._isMounted)
            this.setState({path: path});
        console.log("path: " + JSON.stringify(path));
    }

    getActiveClasses() {
        var classes = {home: "", skills: "", projects: "", samples: "", contact: ""}
        var active_class = "header-links-active";
        switch (this.state.path) {
            case "#loc=skills":
                classes.skills = active_class;
                break;
            case "#loc=projects":
                classes.projects = active_class;
                break;
            case "#loc=samples":
                classes.samples = active_class;
                break;
            case "#loc=contact":
                classes.contact = active_class;
                break;
            default:
                classes.home = active_class;
                break;
        }

        return classes;
    }

    componentWillUnmount() {
        this._isMounted = false;
    }
    render() {

        var active_classes = this.getActiveClasses();
        return (<div id="headerContainer" className="bg-three op-9 vdark container-fluid">
        
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
                            <li id="aboutLink" className="header-link nav-item d-inline-block px-1">
                                <a href="#"
                                   className={"nav-link d-inline-block text-center px-0 position-sticky " + active_classes.home}
                                   >
                                    <div id="aboutText" className="header-link-text font-size-1 text-three">About</div>
                                </a>
                            </li>
                            <li id="skillsLink" className="header-link nav-item d-inline-block px-1">
                            <RouterLink
                                to={{
                                                pathname: "/",
                                                hash: "#loc=skills",
                                                state: {
                                                    pageLoc: "skills"
                                                }
                                            }}
                                className={"nav-link d-inline-block text-center px-0 position-sticky " + active_classes.skills}
                                >
                                <div id="skillsText" className="header-link-text font-size-1 text-three">Skills</div>
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
                                className={"nav-link d-inline-block text-center px-0 position-sticky " + active_classes.projects}
                                >
                                <div id="projectsText" className="header-link-text font-size-1 text-three">Projects</div>
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
                                className={"nav-link d-inline-block text-center px-0 position-sticky " + active_classes.samples}
                                >
                                <div id="samplesText" className="header-link-text font-size-1 text-three">Samples</div>
                            </RouterLink>
                            </li>
                            <li id="contactLink" className="header-link nav-item d-inline-block px-1">
                            <RouterLink
                                to={{
                                                pathname: "/",
                                                hash: "#loc=contact",
                                                state: {
                                                    pageLoc: "contact"
                                                }
                                            }}
                                className={"nav-link d-inline-block text-center px-0 position-sticky " + active_classes.contact}
                                >
                                <div id="contactText" className="header-link-text font-size-1 text-three">Contact</div>
                            </RouterLink>
                            </li>
                            <li id="resumeLink" className="header-link nav-item d-inline-block px-1">
                                <a href="/resumepdf"
                                   className={"nav-link d-inline-block text-center px-0 position-sticky"}
                                   target="_blank">
                                    <div id="resumeText" className="header-link-text font-size-1 text-three">Resume</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

                );
    }
}