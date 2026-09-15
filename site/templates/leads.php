<?php
// The "leads" page only exists to store form submissions and is viewed via
// the Panel. It is set to unlisted in content/leads/leads.txt so it never
// appears in navigation. This template just guards against someone guessing
// the URL directly.
go('/');
