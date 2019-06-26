import React from "react";
import ReactDOM from "react-dom";
import ReactLoading from "react-loading";
import { CSSTransition } from 'react-transition-group';
import Slider from "react-slick";

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

    projectSamplesWrapper(dom, link) {
        if (link) {
            return <a href={"//" + link} className="sample-container-link" target="_blank">{dom}</a>;
        } else {
            return dom;
        }
    }

    projectSamplesDom() {
        var samples = this.state.samples;
        var samples_dom = Object.keys(samples).map(sample => {
            var sample_link = samples[sample].link ? samples[sample].link : "";
            var sample_link_dom = sample_link ? (<div className="sample-link-container text-center">
                <a href={"//" + sample_link} className="link-six vlight">{sample_link}</a>
            </div>) : "";
            var sample_blurb = samples[sample].blurb ? (<div className="sample-blurb-container text-center">
                <p class="small text-six light"> {samples[sample].blurb} </p>
            </div>) : "";

            var sample_info = (sample_blurb || sample_link) ?
                    (<div className="sample-info-container bg-six dark op-9 position-absolute w-100">
                        {sample_blurb}
                        {sample_link_dom}
                    </div>) : "";

            var sample_dom = (<div key={"samp-" + sample}
                 className="resume-project-samples-section h-50"
                 >
                <div className="sample-image-container position-relative">
                    <div className="sample-image-overlay bg-six dark op-5 position-absolute rounded mx-auto" />
                    <div className="sample-name-wrapper position-absolute w-100 text-center">
                        <div className="sample-name-container bg-six dark op-8 rounded mx-auto d-inline-block my-1">
                            <h4 className="sample-name text-six light my-0 px-1">
                                {samples[sample].title}
                            </h4></div>
                    </div>
            
                    <img className="sample-image img-fluid rounded mx-auto" src={"files/images_directory/project_samples/" + samples[sample].project_image} />
                            {sample_info}
            
                </div>
            
            
            </div>);
            sample_dom = this.projectSamplesWrapper(sample_dom, sample_link);

            return sample_dom;
        });

        return samples_dom;
    }

    render() {
        var samples=this.state.samples.length;
        var samples_to_show=samples>1?2:1;
        var arrows_and_infinite=samples>1?true:false;
        var center = samples > 1? false: true;
        console.log("sts: " + samples_to_show);
        console.log("aai: " + arrows_and_infinite);
        console.log("center: " + center);
        const settings = {
            dots: true,
            speed: 500,
            slidesToShow: samples_to_show,
            slidesToScroll: 1,
            infinite: arrows_and_infinite,
            arrows: arrows_and_infinite,
            centerMode: center,
            initialSlide: 0,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: samples_to_show,
                        slidesToScroll: 1,
                        infinite: arrows_and_infinite,
                        arrows: arrows_and_infinite,
                        centerMode: center
                    }
                },
                {
                    breakpoint: 680,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: arrows_and_infinite,
                        arrows: arrows_and_infinite,
                        centerMode: center
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        initialSlide: 0,
                    }
                }
            ]
        };
        var samples_dom = (
                <CSSTransition
                    in={true}
                    appear={true}
                    timeout={1000}
                    classNames="fade"
                    >
                    <div id="projectSamplesDomWrapper" className="w-100 position-absolute content-element bg-six op-9">
                
                        <div id="projectSamplesDomContainer" className="container-fluid w-100 pb-5">
                            <div className="row">
                                <h2 className="section-title text-center col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 text-six light">Project Samples</h2>
                            </div>
                            <div id="projectSamplesRow" className="row my-auto">
                                <div className="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-12">
                                    <Slider {...settings}>
                                        {this.projectSamplesDom()}
                                    </Slider>
                                </div>
                            </div>
                        </div>
                    </div>
                </CSSTransition>
                );

        return samples_dom;
    }

};




