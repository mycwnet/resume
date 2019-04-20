import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import ReactLoading from "react-loading";
import ProfileDisplayHeader from "./ProfileDisplayHeader";
import Proficiencies from "./Proficiencies";
import Histories from "./Histories";
import ProjectSamples from "./ProjectSamples";

var $ = require('jquery');
require('bootstrap');

export default class ProfileDisplay extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            profile: {},
            proficiencies: {},
            histories: {},
            samples: {}
        };
    }

    componentDidMount() {
        this._isMounted = true;
        var self = this;
        axios
                .get("/profileapi")
                .then(function (response) {
                    console.log("response: " + JSON.stringify(response.data));
                    self.setProfileInfo(response.data.user);
                    self.setProficienciesInfo(response.data.proficiencies);
                    self.setHistoryInfo(response.data.histories);
                    self.setProjectSamplesInfo(response.data.samples);
                })
                .catch(function (error) {
                    console.log("GET '/profileapi', " + error);
                });
 
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    }

    setProfileInfo(profile_info) {
        if (this._isMounted)
            this.setState({profile: profile_info});
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

    componentWillUnmount() {
        this._isMounted = false;
    }
    render() {
        console.log("state: " + JSON.stringify(this.state));
        var phone = this.state.profile.phone;
        var email = this.state.profile.email;
        var avatar = this.state.profile.image ? (
                <div id="resumeAvatar" className="col-lg-2 col-md-3 col-4 offset-2">
                    <img src={"files/images_directory/" + this.state.profile.image} className="rounded-circle border bdr-three light w-100"/>
                </div>
                ) : '';
        var profile_dom = (
                <div id="profileDomWrapper">
                        <ProfileDisplayHeader />
                    <div id="profileDomContainer" className="bg-one">
                        <div id="profileTopRow" className="row">
                            <h1 id="resumeTitle" className="text-center col-10 offset-1 text-three">{this.state.profile.title}</h1>
                        </div>
                        <div
                            id="profileMiddleRow"
                            className="resumeIdentitySection row"
                            >
                            {avatar}
                            <div className="resumeIdentityInfo col-4">
                                <h2 class="text-one vlight">{this.state.profile.first_name + " " + this.state.profile.last_name}</h2>
                                <div id="resumeContact">
                                    <a tabindex="0" class="btn btn-sm btn-three" role="button" data-toggle="popover" title="Contact Info" data-content={(email?"Email: " + email :"") + (phone?"<br />Phone: " + phone:"")} data-html="true">Contact</a>
                                </div>
                            </div>
                        </div>
                        <hr className="bdr-three light" />
                        <div id="profileBottomRow" className="row">
                            <div className="resumeBackground col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 text-one vlight">
                                <p>
                                    {this.state.profile.background}
                                </p>
                            </div>
                        </div>
                    </div>
                    <Histories histories={this.state.histories}/>
                    <Proficiencies proficiencies={this.state.proficiencies} />
                    <ProjectSamples samples={this.state.samples}/>
                </div>
                );

        return profile_dom;
    }

};

