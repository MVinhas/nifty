<section id="dbconf_index">
  <div class="alert alert-danger h2" role="alert">
    <span class="fa fa-exclamation-triangle" aria-hidden="true">
    </span>
    <span class="sr-only">Error:
    </span>
    Looks Like your database is not correctly configured
  </div>
  <div class="h4 mt-4 mb-4">Don't worry. Just take the next steps in order to successfully setup your environment.
  </div>
  <div class="h6">Using MySQL command line prompt as 'root':
  </div>
  <pre>
<code class="card card-body">CREATE DATABASE <?=$data->database;?>;
CREATE USER '<?=$data->username;?>'@'<?=$data->host;?>' IDENTIFIED BY '<?=$data->password;?>';
GRANT ALL PRIVILEGES ON <?=$data->database;?>.* TO '<?=$data->username;?>'@'<?=$data->host;?>';
FLUSH privileges;
</code>
<small>
    <p>Technical info:</p>
    <p><?=$data->info;?></p>
</small>
</pre>
</section>