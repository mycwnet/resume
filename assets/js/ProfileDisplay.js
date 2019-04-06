import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import ReactLoading from "react-loading";
import Proficiencies from "./Proficiencies";
import Histories from "./Histories";
import ProjectSamples from "./ProjectSamples";

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
        var phone = this.state.profile.phone ? <div className="resumeContactElement">Phone: {this.state.profile.phone}</div> : "";
        var profile_dom = (
                <div id="profileDomWrapper">
                    <div id="profileDomContainer">
                        <div id="profileTopRow" className="row">
                            <h1 id="resumeTitle" className="text-center col-10 offset-1">{this.state.profile.title}</h1>
                        </div>
                        <div
                            id="profileMiddleRow"
                            className="resumeIdentitySection row"
                            >
                            <div id="resumeAvatar" className="col-lg-4 offset-lg-2 col-5 offset-1">
                                <img src={"files/images_directory/" + this.state.profile.image} className="rounded-circle border border-primary"/>
                            </div>
                            <div className="resumeIdentityInfo col-lg-4 col-5">
                                <h2>{this.state.profile.first_name + " " + this.state.profile.last_name}</h2>
                                <div id="resumeContact">
                                    <div className="resumeContactElement">Email: {this.state.profile.email}</div>
                                    {phone}
                                </div>
                            </div>
                        </div>
                        <div id="profileBottomRow" className="row">
                            <hr />
                            <div className="resumeBackground col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12">
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

