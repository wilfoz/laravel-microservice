// @flow 
import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import routes from '.';

const AppRoute = () => {
    return (
        <Switch>
            {
                routes.map((route, key) => (
                    <Route
                        key={key}
                        name={route.name}
                        path={route.path}
                        component={route.component}
                        exact={route.exact === true}
                    />
                ))
            }
        </Switch>
    );
};

export default AppRoute;