import React from 'react';
import { MapContainer, Marker, Popup, TileLayer, useMap } from 'react-leaflet';

function MyComponent(props) {
  const map = useMap();

  const { position } = props;

  React.useEffect(() => {
    if (position[0] === undefined || position[1] === undefined) {
      return;
    }

    map.setView([position[0], position[1]], 15);
  }, [position]);

  return null;
}

export default function Map(props) {
  const { position } = props;
  const latlong = [position[0], position[1]];

  return (
    <div
      style={{
        width: '100%',
        height: '35vh',
        border: '1px solid #ccc',
        borderRadius: '5px',
        overflow: 'hidden',
      }}
    >
      <MapContainer center={latlong} zoom={13} scrollWheelZoom>
        <TileLayer
          attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        />
        <Marker position={latlong}>
          <Popup>
            <strong>Localização Aproximada!</strong> <br />A localização não é
            precisa e não considera o numero da rua ou avenida atual.
          </Popup>
        </Marker>
        <MyComponent position={latlong} />
      </MapContainer>
    </div>
  );
}
