import React from "react";
import ReactDOM from "react-dom";
import ReactLoading from "react-loading";

export default class ProjectSamples extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            samples: this.props.samples
        };
    }

    componentDidMount() {
        this._isMounted = true;
        this.setProjectSamplesInfo(this.props.samples);
    }

    componentWillReceiveProps(nextProps) {
        this._isMounted = true;
        this.setProjectSamplesInfo(nextProps.samples);
    }

    setProjectSamplesInfo(samples) {
        if (this._isMounted)
            this.setState({samples: samples});
    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    projectSamplesDom() {
        var samples = this.state.samples;
        console.log("sState: " + JSON.stringify(this.state));
        console.log("sProps: " + JSON.stringify(this.props));
        var samples_dom = Object.keys(samples).map(sample => {
            console.log("samp: " + JSON.stringify(sample));
            return(<div key={"samp-" + sample}
                 className="col-lg-4 col-md-12 col-sm-12 resumeProjectSamplesSection"
                 >
                <h2 className="sampleName">
                    {samples[sample].title}
                </h2>
                <div className="sampleBlurb">
                    {samples[sample].blurb}
                </div>
                <div className="sampleLink">
                    {samples[sample].link}
                </div>
                <div className="sampleImage">
                    {samples[sample].project_image}
                </div>
            
            </div>);
        });

        return samples_dom;
    }

    render() {
        console.log("samples: " + JSON.stringify(this.state.samples));
        var samples_dom = (
                <div id="projectSamplesDomWrapper">
                    <div id="projectSamplesDomContainer" className="row">
                        {this.projectSamplesDom()}
                    </div>
                </div>
                );

        return samples_dom;
    }

};




