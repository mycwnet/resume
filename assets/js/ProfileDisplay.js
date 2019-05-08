import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import ReactLoading from "react-loading";
import ProfileDisplayHeader from "./ProfileDisplayHeader";
import Personal from "./Personal";
import Proficiencies from "./Proficiencies";
import Histories from "./Histories";
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

        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    }

    componentDidUpdate(prevProps) {
        this._isMounted = true;
        var curProps = this.props;
        var curPath = curProps.pathVars;
        var prevPath = prevProps.pathVars;
        if (curPath !== prevPath) {
            this.setRouteVars(this.props);
        }
    }

    setRouteVars(props) {
        if (this._isMounted)
            this.setState({routerState: props.stateVars, routerPath: props.pathVars});
    }

    setPersonalInfo(personal_info) {
        if (this._isMounted)
            this.setState({personal: personal_info, loading: false});
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
                    backgroundPosition: "center",
                    backgroundRepeat: "no-repeat",
                    backgroundSize: "cover",
                    backgroundBlendMode: "saturation"
                } : {};
        var profile_dom = (
                <div id="profileDomWrapper" style={style}>
                
                </div>);
        if (!this.state.loading) {
            profile_dom = (
                    <div id="profileDomWrapper" className="position-relative" style={style}>
                        <ProfileDisplayHeader header={this.state.header}/>
                        <TransitionGroup className="info position-relative">
                            <CSSTransition
                                key={this.state.routerState.pageLoc}
                                timeout={2000}
                                classNames="fade"
                                >
                                {this.getComponent()}
                            </CSSTransition>
                        </TransitionGroup>
                    </div>
                    );
        }

        return profile_dom;
    }

};

