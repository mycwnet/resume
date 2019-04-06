import React from "react";
import ReactDOM from "react-dom";
import ReactLoading from "react-loading";

export default class Proficiencies extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            proficiencies: this.props.proficiencies
        };
    }

    componentDidMount() {
        this._isMounted = true;
        this.setProficienciesInfo(this.props.proficiencies);
    }

    componentWillReceiveProps(nextProps) {
        this._isMounted = true;
        this.setProficienciesInfo(nextProps.proficiencies);
    }

    setProficienciesInfo(proficiencies) {
        if (this._isMounted)
            this.setState({proficiencies: proficiencies});
    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    proficienciesDom() {
        var proficiencies = this.state.proficiencies;
        console.log("pState: " + JSON.stringify(this.state));
        console.log("pProps: " + JSON.stringify(this.props));
        var proficiencies_dom = Object.keys(proficiencies).map(proficiency => {
            console.log("prof: " + JSON.stringify(proficiency));
            return(<div key={"prof-" + proficiency}
                className="col-lg-4 col-md-12 col-sm-12 resumeProficiencySection"
                >
                <h2 className="proficiencyName">
                    {proficiencies[proficiency].title}
                </h2>
                <div className="proficiencyYears">
                    {proficiencies[proficiency].years}
                </div>
                <div className="proficiencyPercent">
                    {proficiencies[proficiency].percent}
                </div>
            
            </div>);
        });

        return proficiencies_dom;
    }

    render() {
        console.log("proficiencies: " + JSON.stringify(this.state.proficiencies));
        var proficiencies_dom = (
                <div id="proficienciesDomWrapper">
                    <div id="proficienciesDomContainer" className="row">
                        {this.proficienciesDom()}
                    </div>
                </div>
                );

        return proficiencies_dom;
    }

};




