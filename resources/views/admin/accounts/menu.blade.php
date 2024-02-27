<div class="card card-custom card-stretch">
    <div class="card-body pt-4">
        <div class="d-flex align-items-center">
            <div>
                <a class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">
                
                </a>
            </div>
        </div>
        <div class="py-9">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="font-weight-bold mr-2">Businss Name:</span>
                <span class="text-dark">{{Session('business_name')}}</span>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="font-weight-bold mr-2">User Name:</span>
                <span class="text-dark">{{Session('user_name')}}</span>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="font-weight-bold mr-2">Email:</span>
                <a class="text-dark text-hover-primary">{{Session('email')}}</a>
            </div>
        </div>
        <?php
        $route_name = request()->route()->getName();
        ?>
        <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
            <div class="navi-item mb-2">
                <a href="{{route('account')}}" class="navi-link py-4 {{$route_name=='account'?'active':''}}">
                    <span class="navi-icon mr-2">
                        <i class="fa fa-user"></i>
                    </span>
                    <span class="navi-text font-size-lg">Personal Information:</span>
                </a>
            </div>
            <div class="navi-item mb-2">
                <a href="{{route('account-security')}}" class="navi-link py-4 {{$route_name=='account-security'?'active':''}}">
                    <span class="navi-icon mr-2">
                        <span class="svg-icon">
                            <i class="fas fa-key"></i>
                        </span>
                    </span>
                    <span class="navi-text font-size-lg">Password:</span>
                </a>
            </div>
        </div>
    </div>
</div>