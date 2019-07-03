import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import ReactLoading from "react-loading";
import ProfileDisplayHeader from "./ProfileDisplayHeader";
import ProfileDisplayFooter from "./ProfileDisplayFooter";
import Personal from "./Personal";
import Proficiencies from "./Proficiencies";
import Histories from "./Histories";
import Contact from "./Contact";
import ProjectSamples from "./ProjectSamples";
import { Link as RouterLink } from "react-router-dom";
import { CSSTransition, TransitionGroup } from 'react-transition-group';

var $ = require('jquery');
require('bootstrap');

export default class ProfileDisplay extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            routerState: this.props.stateVars,
            routerPath: this.props.pathVars,
            personal: {},
            proficiencies: {},
            histories: {},
            config: {},
            header: {},
            samples: {}
        };
    }

    componentDidMount() {
        this._isMounted = true;
        this.setRouteVars(this.props);
        var self = this;
        axios
                .get("/profileapi")
                .then(function (response) {
                    self.setPersonalInfo(response.data.user);
                    self.setProficienciesInfo(response.data.proficiencies);
                    self.setHistoryInfo(response.data.histories);
                    self.setProjectSamplesInfo(response.data.samples);
                    self.setConfigInfo(response.data.configuration);
                    self.setHeaderInfo(response.data.configuration);

                })
                .catch(function (error) {
                    console.log("GET '/profileapi', " + error);
                });
        this.handlePopover();
        this.closeNavbarMenu();
    }

    componentDidUpdate(prevProps) {
        this._isMounted = true;
        var curProps = this.props;
        var curPath = curProps.pathVars;
        var prevPath = prevProps.pathVars;
        if (curPath !== prevPath) {
            this.setRouteVars(this.props);
        }
        this.handlePopover();
        this.closeNavbarMenu();
    }

    closeNavbarMenu() {
        $('html').bind('click', function (e) {
            if ($(e.target).closest('.navbar').length == 0) {
                var opened = $('.navbar-collapse').hasClass('collapse show');
                if (opened === true) {
                    $('.navbar-collapse').collapse('hide');
                }
            }
        });
    }

    handlePopover() {
        $(function () {
            $('[data-toggle="popover"]').popover()
        });

        $(document).on('click', function (e) {
            $('[data-toggle="popover"],[data-original-title]').each(function () {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    (($(this).popover('hide').data('bs.popover') || {}).inState || {}).click = false  // fix for BS 3.3.6
                }

            });
        });
    }

    setRouteVars(props) {
        if (this._isMounted)
            this.setState({routerState: props.stateVars, routerPath: props.pathVars});
    }

    setPersonalInfo(personal_info) {
        if (this._isMounted) {
            var CryptoJS = require("crypto-js");
            personal_info.phone = CryptoJS.AES.encrypt(personal_info.phone, 'cwnet r3$um3').toString();
            personal_info.email = CryptoJS.AES.encrypt(personal_info.email, 'cwnet r3$um3').toString();
            this.setState({personal: personal_info, loading: false});
        }
    }
    setProficienciesInfo(proficiencies) {
        if (this._isMounted)
            this.setState({proficiencies: proficiencies});
    }
    setProjectSamplesInfo(samples) {
        if (this._isMounted)
            this.setState({samples: samples});
    }
    setHistoryInfo(project_history) {
        if (this._isMounted)
            this.setState({histories: project_history});
    }
    setConfigInfo(config) {
        if (this._isMounted)
            this.setState({config: config});
    }
    setHeaderInfo(config) {
        var header = {site_title: config.site_title, site_logo: config.site_logo};
        if (this._isMounted)
            this.setState({header: header});
    }
    getComponent() {
        var component_name = this.state.routerState.pageLoc;
        var component = <Personal personal_info={this.state.personal} />;
        switch (component_name) {
            case "skills":
                component = <Proficiencies proficiencies={this.state.proficiencies} />;
                break;
            case "projects":
                component = <Histories histories={this.state.histories}/>;
                break;
            case "samples":
                component = <ProjectSamples samples={this.state.samples}/>;
                break;
            case "contact":
                component = <Contact personal_info={this.state.personal} encrypted={true} />;
                break;
            default:
                component = <Personal personal_info={this.state.personal} />;
                break;
        }

        return component;
    }

    componentWillUnmount() {
        this._isMounted = false;
    }
    render() {
        var style = this.state.config.background_image ?
                {
                    backgroundImage: 'linear-gradient(black, black), url(files/images_directory/' + this.state.config.background_image + ')',
                    backgroundPosition: "center center",
                    backgroundRepeat: "no-repeat",
                    backgroundAttatchment: "fixed",
                    backgroundSize: "cover",
                    backgroundBlendMode: "saturation"
                } : {};
        var profile_dom = (
                <div id="profileDomWrapper" style={style}>
                
                </div>);
        if (!this.state.loading) {
            profile_dom = (
                    <div id="profileDomWrapper" className="position-fixed w-100 h-100" style={style}>
                        <ProfileDisplayHeader header={this.state.header} path={this.state.routerPath}/>
                        <TransitionGroup className="transition-group position-fixed">
                            <CSSTransition
                                key={this.state.routerState.pageLoc}
                                timeout={2000}
                                classNames="fade"
                                >
                                {this.getComponent()}
                            </CSSTransition>
                        </TransitionGroup>
                        <ProfileDisplayFooter footer="true"/>
                    </div>
                    );
        }

        return profile_dom;
    }

};

