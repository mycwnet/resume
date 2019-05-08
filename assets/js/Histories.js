import React from "react";
import ReactDOM from "react-dom";
import ReactLoading from "react-loading";
import { CSSTransition } from 'react-transition-group';
import ReactPaginate from 'react-paginate';

export default class Histories extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            histories: this.props.histories,
            displayHistories: [],
            page_count: 0,
            page: 0
        };
        this.setHistoriesPage = this.setHistoriesPage.bind(this);
    }

    componentDidMount() {
        this._isMounted = true;
        this.setHistoriesInfo(this.props.histories);
    }

    componentWillReceiveProps(nextProps) {
        this._isMounted = true;
        this.setHistoriesInfo(nextProps.histories);
    }

    setHistoriesInfo(histories) {
        var count = Math.ceil(histories.length / 3);
        if (this._isMounted)
            this.setState(
                    {histories: histories, page_count: count},
                    () => {
                this.setDisplayHistories()
            }
            );
    }
    setHistoriesPage(data) {
        if (this._isMounted)
            this.setState({page: data.selected}, () => {
                this.setDisplayHistories();
            });

    }

    setDisplayHistories() {
        var page = this.state.page;
        var display = [];
        if (this._isMounted) {
            for (var i = page; i < page + 3; i++) {
                if (this.state.histories[i]) {
                    display.push(this.state.histories[i]);
                }
            }
            this.setState({displayHistories: display});
        }

    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    historiesDom() {
        var histories = this.state.displayHistories;
        var histories_dom = Object.keys(histories).map(history => {
            return(<div key={"hist-" + history} className="row">
                <div className="col-lg-8 offset-lg-2 col-10 offset-1 resume-history-section">               <h3 className="history-name text-two light">
                        {histories[history].title}
                    </h3>
                    <p className="history-description text-two vlight">
                        {histories[history].description}
                    </p>
                    <div className="history-start text-two dark d-inline-block">
                        From {histories[history].start}
                    </div>
                    <div className="history-end text-two dark d-inline-block mx-1">
                        to {histories[history].end}
                    </div>
                </div>
            
            </div>);
        });

        return histories_dom;
    }

    render() {
        var histories_dom = (
                <CSSTransition
                    in={true}
                    appear={true}
                    timeout={1000}
                    classNames="fade"
                    >
                    <div id="historiesDomWrapper" className="position-absolute content-element w-100">
                        <div id="historiesDomContainer" className="container-fluid bg-two op-9 h-100">
                            <div className="row">
                                <h2 className="section-title text-center col-10 offset-1 text-two dark font-size-5">Project History</h2>
                            </div>
                            <div id="historiesInfoContainer">
                                {this.historiesDom()}
                            </div>
                            <div id="historiesPaginationRow" className="row">
                                <div className="col-6 offset-3 d-flex justify-content-center">
                                    <ReactPaginate
                                        previousLabel={ < i class = "far fa-arrow-alt-circle-left" > </i>}
                                        nextLabel={ < i class = "far fa-arrow-alt-circle-right" > </i>}
                                        breakLabel={'...'}
                                        breakClassName={'break-me'}
                                        pageCount={this.state.page_count}
                                        marginPagesDisplayed={2}
                                        pageRangeDisplayed={0}
                                        onPageChange={this.setHistoriesPage}
                                        containerClassName={'pagination'}
                                        subContainerClassName={'pages pagination'}
                                        activeClassName={'active'}
                                        pageLinkClassName={'btn btn-outline-two dark'}
                                        previousLinkClassName={'btn btn-outline-two dark'}
                                        nextLinkClassName={'btn btn-outline-two dark'}
                                        pageClassName={'mx-1'}
                                        previousClassName={'mx-1'}
                                        nextClassName={'mx-1'}
                                        disabledLinkClassName={'disabled'}
                                        activeLinkClassName={'active'}
                
                                        />
                                </div>
                            </div>
                
                        </div>
                    </div>
                </CSSTransition>
                );

        return histories_dom;
    }

};
