<template>
    <div class="container font-weight-normal">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header text-primary font-weight-bold">
                        <div class="row">
                            <div class="col-sm-8 text-left pt-1">
                                My Teams
                            </div>
                            <div class="col-sm-4 text-right">
                                <button type="button" class="btn btn-dark btn-sm" @click="showTeamForm">Add +</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="add-team" class="p-sm-4" v-show="show.team_form">
                            <div class="form-group">
                                <label for="new-team-name">Create a New Team!</label>
                                <input v-if="show.team_form" v-focus v-highlight type="text" class="form-control text-center" id="new-team-name" placeholder="Enter new team name" v-model="form.team.name">
                            </div>
                            <button type="button" class="btn btn-primary mb-3" @click="saveTeam">Add Team</button>
                            <button type="button" class="btn btn-primary mb-3 ml-3" @click="cancelTeam">Cancel</button>
                        </div>
                        <ul class="list-group">
                            <li v-for="team in teams" v-bind:value="team.id" class="team-item list-group-item-action list-group-item" @click="teamSelected(team.id)">{{ team.name }} <span class="badge badge-primary badge-pill float-right">{{ team.players.length }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6" v-show="selected.team">
                <div class="card card-default">
                    <div class="card-header text-primary font-weight-bold">
                        <div class="row">
                            <div class="col-sm-8 text-left pt-1">
                                {{ team_name }} Players
                            </div>
                            <div class="col-sm-4 text-right">
                                <button type="button" class="btn btn-dark btn-sm" @click="showPlayerForm">Add +</button>
                            </div>
                        </div>
                    </div>
                    <div id="add-player" class="p-sm-4" v-show="show.player_form || show.edit_player">
                        <div class="form-group">
                            <label for="new-player-first-name">
                                <span v-show="show.player_form">Add Player to Team</span>
                                <span v-show="show.edit_player">Edit Player</span>
                            </label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input v-if="show.player_form || show.edit_player" v-focus v-highlight type="text" class="form-control text-center" id="new-player-first-name" placeholder="First name" v-model="form.player.first_name">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control text-center" id="new-player-last-name" placeholder="Last name" v-model="form.player.last_name">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mb-3" @click="savePlayer">
                            <span v-show="show.player_form">Add</span>
                            <span v-show="show.edit_player">Save</span> Player
                        </button>
                        <button type="button" class="btn btn-primary mb-3 ml-3" @click="cancelPlayer">Cancel</button>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li v-for="(player, index) in players" v-bind:value="player.id" class="player-item list-group-item-action list-group-item" @click="playerSelected(player.id)">
                                <span class="badge badge-secondary float-left"># {{ index + 1 }}</span> {{ player.full_name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data      : function ()
        {
            return {
                api_url   : 'http://nathanhuebner.com/api',
                api_params: {
                    api_token: '9e9d457f8cf40cdf62eebccb3fd1690a',
                },
                teams     : [],
                players   : [],
                team_name : null,
                show      : {
                    team_form  : false,
                    player_form: false,
                    edit_player: false
                },
                selected  : {
                    team  : false,
                    player: false
                },
                form      : {
                    team  : {
                        name: ''
                    },
                    player: {
                        team_id   : null,
                        first_name: '',
                        last_name : ''
                    }
                }
            }
        },
        mounted() {
            this.reloadTeams();
        },
        methods   : {
            api                         : function (endpoint, method, data, callback, onerror)
            {
                axios({method: method, url: this.api_url + endpoint, params: this.api_params, data: data})
                    .then(response => (typeof callback == 'function' ? callback(response) : this.info = response))
                    .catch(response => (typeof onerror == 'function' ? onerror(response) : console.log(response)));
            },
            apiGenericError             : function (response)
            {
                alert("Woops!\n\nThere was a problem while trying to load data.\n\nCheck your API URL and Token.\n\n" + response);
            },
            teamsUrl                    : function ()
            {
                return '/teams';
            },
            playerUrl                   : function ()
            {
                return '/teams/' + this.selected.team + '/player' +
                    ( this.selected.player ? '/' + this.selected.player : '');
            },
            reloadTeams                 : function ()
            {
                var self = this;
                
                this.api(this.teamsUrl(), 'get', null, function (response)
                {
                    self.teams = response.data.data;
                }, function (response)
                {
                    self.apiGenericError(response);
                });
            },
            showTeamForm                : function ()
            {
                this.cancelTeam();
                this.show.team_form = true;
            },
            showPlayerForm              : function ()
            {
                this.cancelPlayer();
                this.show.player_form    = true;
                this.form.player.team_id = this.selected.team;
            },
            saveTeam                    : function ()
            {
                var self = this;

                this.api(this.teamsUrl(), 'put', self.form.team, function (response)
                {
                    var new_team = response.data.data;

                    self.cancelTeam();
                    self.cancelPlayer();
                    self.teams = self.teams.concat(new_team);
                }, function (response)
                {
                    if ( typeof response == 'object' && 'error' in response )
                    {
                        alert(response.error);
                        return;
                    }

                    self.apiGenericError(response);
                });
            },
            savePlayer                  : function ()
            {
                var self   = this;
                var method = ( this.selected.player ? 'patch' : 'put' );

                this.api(this.playerUrl(), method, self.form.player, function (response)
                {
                    var saved_player = response.data.data;

                    self.playerUpdate(saved_player);
                    self.cancelPlayer();
                }, function (response)
                {
                    if ( typeof response == 'object' && 'error' in response )
                    {
                        alert(response.error);

                        return;
                    }

                    self.apiGenericError(response);
                });
            },
            playerUpdate                : function (player)
            {
                var team_index   = this.getTeamIndexByTeamId(player.team_id);
                var player_index = this.getTeamPlayerIndexByPlayerId(player.id);

                if ( team_index != null && player_index != null )
                {
                    this.teams[team_index].players[player_index] = player;
                }

                if ( team_index != null && player_index == null )
                {
                    this.teams[team_index].players = this.teams[team_index].players.concat(player);
                }

                if ( this.selected.team == player.team_id )
                {
                    this.players = this.teams[team_index].players;
                }
            },
            getTeamPlayerIndexByPlayerId: function (player_id)
            {
                for ( var team in this.teams )
                {
                    for ( var player in this.teams[team].players )
                    {
                        if ( this.teams[team].players[player].id == player_id )
                        {
                            return player;
                        }
                    }
                }

                return null;
            },
            getTeamIndexByTeamId        : function (team_id)
            {
                for ( var team in this.teams )
                {
                    if ( this.teams[team].id == team_id )
                    {
                        return team;
                    }
                }

                return null;
            },
            teamSelected                : function (team_id)
            {
                this.cancelTeam();
                this.cancelPlayer();

                this.selected.team = null;
                this.players       = [];
                
                for ( var team in this.teams )
                {
                    if ( this.teams[team].id == team_id )
                    {
                        this.selected.team = team_id;
                        this.team_name     = this.teams[team].name;
                        this.players       = this.teams[team].players;
                        break;
                    }
                }
            },
            playerSelected              : function (player_id)
            {
                this.cancelPlayer();

                for ( var player in this.players )
                {
                    if ( this.players[player].id == player_id )
                    {
                        this.selected.player  = player_id;
                        this.form.player      = this.players[player];
                        this.show.edit_player = true;
                        break;
                    }
                }
            },
            cancelPlayer                : function ()
            {
                this.show.edit_player = false;
                this.show.player_form = false;
                this.form.player      = {};
                this.selected.player  = null;
            },
            cancelTeam                  : function ()
            {
                this.show.team_form = false;
            }
        },
        directives: {
            focus    : {
                inserted: function (el)
                {
                    Vue.nextTick(() => el.focus());
                }
            },
            highlight: {
                inserted: function (el)
                {
                    Vue.nextTick(() => el.select());
                }
            }
        }
    }
</script>
