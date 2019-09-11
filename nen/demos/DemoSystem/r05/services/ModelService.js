"use strict";
var ModelService = {};

/**
* ModelService
*
* @class ModelService
*/
(function(Service) {

    var models = [];

    Service.addModel = function(model)
    {
        if (!(model instanceof Model))
        {
            return;
        }

        models.push(model);
    };

    Service.getModels = function()
    {
        return models;
    };

    Service.getModelByMesh  = function(mesh)
    {
        if (!(mesh instanceof THREE.Mesh))
        {
            return null;
        }

        for (var i=0; i<models.length; i++)
        {
            var model = models[i];
            if (model.getObject() == mesh)
            {
                return model;
            }
        }

        return null;
    };

    Service.animateAll = function()
    {
        for (var i=0; i<models.length; i++)
        {
            var model = models[i];
            model.animate();
        }
    };

})(ModelService);
