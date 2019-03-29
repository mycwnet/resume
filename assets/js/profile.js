import React from 'react';

var $ = require('jquery');
require('bootstrap');


var projectHistoryCollection;
var proficiencyCollection;
var samplesCollection;
var addProjectHistoryButton = $('<button type="button" class="btn btn-secondary my-2 add_project_history">Add Project</button>');
var addProficiencyButton = $('<button type="button" class="btn btn-secondary my-2 add_proficiency">Add Proficiency</button>');
var addSampleButton = $('<button type="button" class="btn btn-secondary my-2 add_sample">Add Sample</button>');
$(document).ready(function () {
    projectHistoryCollection = $('#histories_collapse');
    proficiencyCollection = $("#proficiencies_collapse");
    samplesCollection = $("#samples_collapse");

    //set index value for project history collections
    projectHistoryCollection.data('index', projectHistoryCollection.find('.card').length);
    var histindex = 0;
    projectHistoryCollection.find('.card').each(function () {
        histindex = histindex + 1;
        addDeleteHistoryButton($(this), histindex);
    });
    projectHistoryCollection.append(addProjectHistoryButton);

    addProjectHistoryButton.click(function (e) {
        e.preventDefault();
        addProjectHistoryCollection();
    });

    //set index value for proficiencies collections
    proficiencyCollection.data('index', proficiencyCollection.find('.card').length);
    var profindex = 0;
    proficiencyCollection.find('.card').each(function () {
        profindex = profindex + 1;
        addDeleteProficiencyButton($(this), profindex);
    });
    proficiencyCollection.append(addProficiencyButton);

    addProficiencyButton.click(function (e) {
        e.preventDefault();
        addProficiencyCollection();
    });
    //set index value for samples collections
    samplesCollection.data('index', samplesCollection.find('.card').length);
    var sampindex = 0;
    samplesCollection.find('.card').each(function () {
        sampindex = sampindex + 1;
        addDeleteSampleButton($(this), sampindex);
    });
    samplesCollection.append(addSampleButton);

    addSampleButton.click(function (e) {
        e.preventDefault();
        addSampleCollection();
    });
    $('#project_samples_list').on('change', '.custom-file-input', function (e) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
        console.log('file: ' + e.target.files[0].name);
    });
});

function addProjectHistoryCollection() {
    var prototype = projectHistoryCollection.data('prototype');
    var index = projectHistoryCollection.data('index');
    var projectForm = prototype.replace(/__name__/g, index);

    projectHistoryCollection.data('index', index + 1);

    var projectHistoryCard = $('<div class="card my-2"><div class="card-header"></div></div>');
    var project = $('<div class="card-body"></div>').append(projectForm);

    projectHistoryCard.append(project);
    addDeleteHistoryButton(projectHistoryCard, index + 1);

    addProjectHistoryButton.before(projectHistoryCard);
}

function addDeleteHistoryButton(project, index) {

    //console.log(index);
    if (index > 1) {
        var deleteProjectHistoryButton = $('<button type="button" class="btn btn-warning my-2 del_project_history">Remove Project</button>');

        var cardfooter = $('<div class="card-footer"></div>').append(deleteProjectHistoryButton);
        deleteProjectHistoryButton.click(function (e) {
            e.preventDefault();
            $(e.target).parents('.card').remove();
        });

        project.append(cardfooter);
    }

}

function addProficiencyCollection() {
    var prototype = proficiencyCollection.data('prototype');
    var index = proficiencyCollection.data('index');
    var proficiencyForm = prototype.replace(/__name__/g, index);

    proficiencyCollection.data('index', index + 1);

    var proficiencyCard = $('<div class="card my-2"><div class="card-header"></div></div>');
    var proficiency = $('<div class="card-body"></div>').append(proficiencyForm);

    proficiencyCard.append(proficiency);
    addDeleteProficiencyButton(proficiencyCard, index + 1);

    addProficiencyButton.before(proficiencyCard);
}

function addDeleteProficiencyButton(proficiency, index) {

    //console.log(index);
    if (index > 1) {
        var deleteProficiencyButton = $('<button type="button" class="btn btn-warning my-2 del_proficiency">Remove Proficiency</button>');

        var cardfooter = $('<div class="card-footer"></div>').append(deleteProficiencyButton);
        deleteProficiencyButton.click(function (e) {
            e.preventDefault();
            $(e.target).parents('.card').remove();
        });

        proficiency.append(cardfooter);
    }

}

function addSampleCollection() {
    var prototype = samplesCollection.data('prototype');
    var index = samplesCollection.data('index');
    var sampleForm = prototype.replace(/__name__/g, index);

    samplesCollection.data('index', index + 1);

    var sampleCard = $('<div class="card my-2"><div class="card-header"></div></div>');
    var sample = $('<div class="card-body"></div>').append(sampleForm);

    sampleCard.append(sample);
    addDeleteSampleButton(sampleCard, index + 1);

    addSampleButton.before(sampleCard);
}

function addDeleteSampleButton(sample, index) {

    //console.log(index);
    if (index > 1) {
        var deleteSampleButton = $('<button type="button" class="btn btn-warning my-2 del_sample">Remove Sample</button>');

        var cardfooter = $('<div class="card-footer"></div>').append(deleteSampleButton);
        deleteSampleButton.click(function (e) {
            e.preventDefault();
            $(e.target).parents('.card').remove();
        });

        sample.append(cardfooter);
    }

}