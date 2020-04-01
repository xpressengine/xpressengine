<div class="card">
    <div class="card-header">
        <h3>System Info</h3>
    </div>
    <div class="card-body">
        <ul>
            <li>WebServer : {{ $viewData['serverSoftware'] }}</li>
            <li>PHP Version : {{ $viewData['phpVersion'] }}</li>
            <li>Debug Mode : {{ $viewData['debugMode'] }}</li>
            <li>Cache Driver : {{ $viewData['cacheDriver'] }}</li>
            <li>Document Root : {{ $viewData['documentRoot'] }}</li>
            <li>Maintenance : {{ ($viewData['maintenanceMode'])?"On":"Off" }}</li>
            <li>TimeZone : {{ $viewData['timeZone'] }}</li>
        </ul>
    </div>
</div>
