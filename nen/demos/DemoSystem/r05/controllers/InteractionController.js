"use strict";
/**
* InteractionController for interacting with objects
*/
var InteractionController = function(camera, scene)
{
    var raycaster = new THREE.Raycaster();
    raycaster.far = 10.0;

    var interactiveObjects = [];
    var intersected = null;

    // Intersection hover object
    var geometry = new THREE.PlaneGeometry(5.0, 5.0);
    var material = new THREE.MeshLambertMaterial({ color: 0xAAAAFF });
    material.map = THREE.ImageUtils.loadTexture("textures/magnifier.png");
    material.transparent = true;
    this.mesh = new THREE.Mesh(geometry, material);
    this.mesh.visible = false;

    scene.add(this.mesh);

    this.registerObjects = function(models)
    {
        if (models instanceof Array)
        {
            for (var i=0; i<models.length; i++)
            {
                var model = models[i];
                this.registerObject(model);
            }
        }
    };

    this.registerObject = function(model)
    {
        if (model instanceof THREE.Mesh)
        {
            interactiveObjects.push(model);
        }
    };

    this.update = function()
    {
        camera.updateProjectionMatrix();
        camera.updateMatrixWorld();

        // Origin to cast the ray from (camera)
        var origin = new THREE.Vector3(0.0, 0.0, 0.0).applyMatrix4(camera.matrixWorld);

        // Direction to send the ray to
        var direction = new THREE.Vector3(0.0, 0.0, 1.0);
        direction = direction.unproject(camera).sub(origin).normalize();
        raycaster.set(origin, direction);

        // Note! Raycaster.setFromCamera assumes that camera is not a child, so it's not gonna work in this case
        //raycaster.setFromCamera(new THREE.Vector2(0, 0), camera);
        var intersects = raycaster.intersectObjects(interactiveObjects, true);

        if (intersects.length > 0)
        {
            intersected = intersects[0];
            this.setIntersectionHover(true, origin);
        }
        else
        {
            intersected = null;
            this.setIntersectionHover(false, origin);
        }
    };

    this.onInteract = function()
    {
        if (intersected == null)
        {
            return;
        }

        var mesh = intersected.object;
        var interaction = InteractionService.getInteractionByMesh(mesh);
        InteractionService.apply(interaction, mesh);
    };

    this.setIntersectionHover = function(bool, origin)
    {
        if (bool)
        {
            var from = origin;
            var to = intersected.point;

            // Get a vector between from and to, at 75%
            var position = to.sub(from).multiplyScalar(0.75).add(from);
            this.mesh.position.copy(position);

            // TODO Get proper rotation along the camera
            var rotationX = camera.parent.rotation.x;
            var rotationY = camera.parent.parent.rotation.y;
            this.mesh.rotation.set(rotationX, rotationY, 0.0);

            this.mesh.visible = true;
        }
        else
        {
            this.mesh.position.set(0, 0, 0);
            this.mesh.rotation.set(0, 0, 0);
            this.mesh.visible = false;
        }
    }
};
