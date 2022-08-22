# PrivateHub

PrivateHub is a web interface designed to help with the management of containers images.
It is inspired by DockerHub website and the docker Registry API V2.

## Requirements

- Windows with WSL or Linux system.
- Docker Desktop application up and running.

## Installation

### Registry's set up

The remote registry's image used for this project is avaible at : 

https://hub.docker.com/r/astenmco/privatehub

Pull this image from the hub and run it locally using : 

`docker container run -d -p <host_port>:5000 -e REGISTRY_STORAGE_DELETE_ENABLED=true --restart=always -v <host_path>:/var/lib/registry [--name <container_name>] astenmco/privatehub:1 `

Here is an example :

`docker container run -d -p 5000:5000 -e REGISTRY_STORAGE_DELETE_ENABLED=true --restart=always -v $(pwd)/registry-data:/var/lib/registry --name my.registry astenmco/privatehub:1 `

Once the registry container is up and running you can manage it according to the Docker Registry HTTP API V2.
The API calls are made throught Docker-CLI or using the PrivateHub solution.

For more information on how to set up a private remote registry, please visit [EasyLinux](https://www.easylinux.fr/ "EasyLinux") or [DevOpsSec.fr](http://https://devopssec.fr/article/deployer-manipuler-securiser-un-serveur-registry-docker-prive "DevOpsSec.fr")

#### Example

Assuming our registry is hosted on the localhost.

Pulling an hello-world image from the public registry Docker Hub :

`docker image pull hello-world`

Renaming it :

`docker image tag hello-world:latest <host>:<host_port>/<image_name>:<image_version>`

Pushing it to our private registry:

`docker image push localhost:5000/hello-world:1.0`

Once pushed to the registry, your image will appear within your private hub.

### PrivateHub configuration

Once you have set up your private registry, configure your PrivateHub from the : `/src/php/config.php` file.
There you must indicate the registry's host adress and port configuration.

The index.php page will show you if the registry has been proprely configurated by redirecting you to the repositories.php page or to an error display page.

Make sure you use the same configurations for host and port than the ones used for 

## Usage 

Copy the files onto your server and access it using this URL from your web browser:

` <host>/PrivateHub/public/`

For exemple, from my localhost I used : **http://127.0.0.1:5000/PrivateHub/public/** to access the welcome page. 


### Displaying container's image information 

#### Repositories 
PrivateHub lists all the image repositories of your registry within the repositories page. 
Each repository is presented with some of its information.
You can access each repository from the "Open" button.

#### Tags 
Each image repository lists all the tags avaible for this image.
Each tag is presented with some of its information and navigation options.
You can access each tag from the "Open" button next to its platform information.

#### Commands 
Each tag lists all the commands contained within its metadata.
The commands correspond to the DockerFile configuration commands for the speficic platform container selected.

### Deleting image tags 

#### Buttons
The graphic interface provides a range of buttons calling for the tag(s) deletion.
You can either delete the whole repository tags or a specific tag within a specific repository.
Also, you can delete the images older than XXX days by selecting the option from the drop down menu of the repository page.
Finally, you have the option to delete all the images from the registry using the option from the drop down menu of the repository page.

Disk usage is reduced when deleting tags but most of the files are still present within the registry.

**As Docker advices, you should run garbage collection to free up maximum disk space.**

#### Garbage collection

To run garbage collection you can run this command from the host system.

`docker container run -d -v host_path:/var/lib/registry astenmco/privatehub:1 /bin/registry garbage-collect -m /etc/docker/registry.config.yml`

This will launch a container we have set up to execute garbage collection on the actual registry container.
You can chose to automate this job using CRON for example or Kubertenes for advanced users. 

#### Delete repository

As per now, Docker API Registry V2 does not allow to delete repositories.
You could use this command to run the script made to delete empty repositories from the registry.

`docker container run -d -v <host_path>:/var/lib/registry -e  PORT=<host_port> [REGISTRY=host] astenmco/privatehub:1 /usr/bin/remove_empty.sh`

This will launch a container we have set up to execute the clean up job on the actual registry container.
You can chose to automate this job using CRON for example or Kubertenes for advanced users. 
I recommend to run it often as the API lacks this deletion and that would cause some discrepancy between the registry's state and its API.
For now, if I delete all tags from the *hello* repository, the registry will list the repository as part of the registry but will not display it.

### Docker compose
To facilitate the usage of these containers, we have gathered them inside a docker-compose.yaml file.
Open a terminal within the /src/ folder and run this commands on your Ubuntu system or WSL to access the services :

`export REGISTRY="<host>" && export PORT="<host_port>"`

To launch the registry container.
`docker compose up -d registry` 

To launch the registry's cleanup.
`docker compose up -d registry_cleanup`

To launch garbage collection.
`docker compose up -d registry_garbage`

Once again, the cleanups task can be automated using crontab for example.

### Tests
To run the tests for our PrivateHub registry, open a terminal from the root of the PrivateHub project.

Push these images onto your registry :

Nginx [NGINX - 3.16-ppc64le](https://hub.docker.com/r/astenmco/test-nginx/tags "NGINX")

Traefik [TRAEFIK - 2.6-10](https://hub.docker.com/r/astenmco/traefik/tags "TRAEFIK")

Hello [HELLO - v1](https://hub.docker.com/layers/library/hello-world/linux/images/sha256-f54a58bc1aac5ea1a25d796ae155dc228b3f0e11d046ae276b39c4bf2f13d8c4?context=explore "HELLO WORLD")

The images used in the tests must match the images wihtin the repository.

Then run the tests by running this command : 

` ./vendor/bin/phpunit --testdox tests`

Have a look at [PHPUnit](https://phpunit.de/ "PHPUnit").

### Documentation

Install phpDocumentor and generate new documentation using :

` phpDocumentor -d ./src/ -d ./public/ -d ./tests/ -t docs/api`

Have a look at  [PHPDocumentor](https://phpdoc.org/ "PHPDocumentor").