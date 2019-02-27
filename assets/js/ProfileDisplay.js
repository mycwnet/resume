import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import ReactLoading from "react-loading";
import Proficiencies from "./Proficiencies";
import Histories from "./Histories";

export default class ProfileDisplay extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            profile: {},
            proficiencies: {},
            histories: {}
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
                    <div id="profileDomContainer" className="row">
                        <h1 id="resumeTitle" className="col-12">{this.state.profile.title}</h1>
                        <div
                            id="resumePersonalInfo"
                            className="row resumePersonalSection"
                            >
                            <h2 className="resumeName col-lg-4 col-6">
                                {this.state.profile.first_name + " " + this.state.profile.last_name}
                            </h2>
                            <div id="resumeAvatar" className="col-lg-4 col-6">
                                <img src={"files/images_directory/" + this.state.profile.image} />
                            </div>
                            <div id="resumeContact" className="col-lg-4 col-12">
                                <div className="resumeContactElement">Email: {this.state.profile.email}</div>
                                {phone}
                            </div>
                            <hr />
                            <p className="resumeBackground">
                                {this.state.profile.background}
                            </p>
                        </div>
                    </div>
                    <Histories histories={this.state.histories}/>
                    <Proficiencies proficiencies={this.state.proficiencies} />
                </div>
                );

        return profile_dom;
    }

};

