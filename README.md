# Display  your current track on last.fm

This is a simple PHP function that will get your most recently played from Last FM and display:

- Track Name
- Artist Name
- Album Artwork

This is a simple drop-in function which will retrieve track info from the `recentracks` endpoint. If you're currently playing a track, then this will reflect and change 'Last Played' to 'Currently Playing.

To use this, you'll need your last.fm username and API keys (which you can [generate from here](https://www.last.fm/api/account/create "generate from here"))

I'm currently using this in the footer of [my blog](https://jonashcroft.co.uk "my blog")